<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class ScrappingController extends Controller
{
    public function index()
    {
		$client = new Client();
		$crawler = $client->request('GET', 'http://banjarmasin.tribunnews.com/kalsel/');
		$url = $crawler->filter('ul#latestul > li.art-list')->each(function ($node) {
  		$title = $node->filter('div.mr140 h3 > a')->extract(array('_text', 'href'));
  		//dd(str_replace('"', '', $title[0][1]));
  		//$judul = (isset($title) ? $title[0][0] : '');
  			
		    return [
	    	    'title' => str_replace(array("\n","\t"), "", (isset($title[0]) ? $title[0][0] : '')),
			    'link' => urldecode((isset($title[0]) ? $title[0][1] : ''))
		    	//'title' => trim(str_replace("\t", "", $node->text()))
		    ];
		    
		   //echo (isset($title[0]) ? $title[0][0] : '');
		});
	  return response($url);
	 //var_dump($crawler);
    }
}
