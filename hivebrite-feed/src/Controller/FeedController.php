<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Feed;

class FeedController extends Controller
{
    public function index(SerializerInterface $serializer, Request $request)
    {
		$community = $request->query->get('community', null);
		$params = $request->query->all();

		$path = __DIR__.'/../../public/feeds/'.$community.'.json';

		if (!file_exists($path)) {
			return $this->render('404.html.twig');
		}

		$data = file_get_contents($path);
		$feed = $serializer->deserialize($data, Feed::class, 'json');

        return $this->render('feed.html.twig', array(
        	'feed' 				 => $feed,
			'params'             => $params,
        ));
    }
}
