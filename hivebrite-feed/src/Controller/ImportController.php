<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportController extends Controller
{
    public function index($community = '', KernelInterface $kernel)
    {
        $application = new Application($kernel);
		$application->setAutoExit(false);

        $commandConfig = array(
            'command' => 'feed:import',
        );

        if($community !== '') {
            $commandConfig['community'] = $community;
        }

		$input = new ArrayInput($commandConfig);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
        return new Response(nl2br($content));
    }
}
