<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Filesystem\Filesystem;

use App\Service\Api\HivebriteConnector;
use App\Entity\Feed;
use App\Entity\FeedItem;

class ImportFeedCommand extends Command
{
	/** @var HivebriteConnector */
	private $api;

	/** @var SerializerInterface */
	private $serializer;

	/** @var Int */
	private $defaultWaitTime;

	/** @var Bool */
	private $ignoreWaitTime = false;

	public function __construct(HivebriteConnector $api, SerializerInterface $serializer)
	{
		parent::__construct();

		$this->api = $api;
		$this->serializer = $serializer;
	}

    protected function configure()
    {
		$this
        	->setName('feed:import')
        	->setDescription('Task to create/update content for feeds.')
        	->setHelp('This command allows you to update the content displayed in the feeds. It makes sense to run it recurringly through a cron job.')
        	->addArgument('community', InputArgument::OPTIONAL, 'The community which should be updated. All communities will be imported if omitted.')
        	->addOption(
		        'ignoreWaitTime',
		        'i',
		        InputOption::VALUE_NONE,
		        'Should the importer ignore the configured wait time?'
		    );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$output->writeln([
			'',
	        ' Import Feed Data.',
	        ' ~~~~~~~~~~~~~~~~~',
	        '',
	    ]);

		$config = $this->api->getConfiguration();

		$this->defaultWaitTime = ($config['waitTime'] ? $config['waitTime'] : 3600);
		$this->ignoreWaitTime = $input->getOption('ignoreWaitTime');

		$community = $input->getArgument('community');
		if($community) {
			$output->writeln('<comment> -> Only importing ' . $community . '</comment>');

			$config['communities'] = array_filter(
				$config['communities'],
				function ($key) use ($community) {
			        return ($key == $community);
			    },
				ARRAY_FILTER_USE_KEY
			);
		}

		if (empty($config['communities'])) {
			$output->writeln('<error> !! No community found.</error>');
			exit;
		}

		$output->writeln('<comment> -> Found ' . count($config['communities']) . ' communities.</comment>');

		foreach($config['communities'] as $community) {
			if (!$this->shouldImportRun($community)) {
				$output->writeln('<comment> -> ' . $community['name'] . ' Skiped! Waiting time between imports not passed.</comment>');
				continue;
			}

			$output->writeln('<comment> -> Importing ' . $community['name'] . '</comment>');
			if (!$this->api->authenticate($community)) {
				$output->writeln('<error> !! Login failed </error>');
				continue;
			}

			$feed = new Feed();
			$feed->setCommunityName($community['name']);
			$feed->setCommunityDescription($community['description']);
			$feed->setCommunityLogo($community['logo']);
			$feed->setCommunityUrl($community['url']);

			$events = $this->api->get($community, 'events');

			$eventCount = 0;

			foreach($events->events as $event) {
				$eventInfo = $this->api->get($community, 'events/'.$event->id);

				if(!$eventInfo->event->published) {
					continue;
				}

				$feedItem = new FeedItem();
				$feedItem->setType('event');
				$feedItem->setTitle($event->title);
				$feedItem->setPublished(new \DateTime($eventInfo->event->start_date));
				$feedItem->setBody($eventInfo->event->description);
				$feedItem->setUrl($community['url'].'/networks/events/'.$event->id);

				$meta = array(
					'organizer' => $eventInfo->event->organizer,
					'location' => $event->location,
					'venue' => $eventInfo->event->venue,
					'start' => $eventInfo->event->start_date,
					'end' => $eventInfo->event->end_date,
					'public' => $eventInfo->event->public,
				);
				$feedItem->setMeta($meta);

				$feed->addFeedItem($feedItem);

				$eventCount++;
			}
			// write to json
			$jsonContent = $this->serializer->serialize($feed, 'json');
			$fileSystem = new Filesystem();
			$filePath = __DIR__ . '/../../public/feeds/' . $community['slug'] . '.json';
			$fileSystem->dumpFile($filePath, $jsonContent);
			$fileSystem->chmod($filePath, 775);

			$output->writeln('<info> -> Importing ' . $community['name'] . ' finished. ' . $eventCount . ' events imported.</info>');
		}
		$output->writeln('<info> -> DONE </info>');
    }

    protected function shouldImportRun($community) {
    	if ($this->ignoreWaitTime) return true;
    	$now = time();
    	$fileTime = filemtime(__DIR__.'/../../public/feeds/'.$community['slug'].'.json');
    	$difference = (isset($community['waitTime']) ? $community['waitTime'] : $this->defaultWaitTime);
    	return (($now - $fileTime) > $difference);
    }
}
