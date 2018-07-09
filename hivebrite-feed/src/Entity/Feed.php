<?php

namespace App\Entity;

use App\Entity\FeedItem;

class Feed
{
	/** @var string */
	private $community_name;

	/** @var string */
	private $community_description;

	/** @var string */
	private $community_logo;

	/** @var string */
	private $community_url;

	/** @var \DateTime */
	private $last_fetched;

	/** @var FeedItem[] */
	private $feed_items;

	public function __construct()
    {
		$this->last_fetched = new \DateTime();
		$this->feed_items = [];
	}

	/**
	 * @return string
	 */
	public function getCommunityName() {
		return $this->community_name;
	}

	/**
	 * @param string $community_name
	 * @return string
	 */
	public function setCommunityName($community_name) {
		$this->community_name = $community_name;

		return $this->community_name;
	}

	/**
	 * @return string
	 */
	public function getCommunityDescription() {
		return $this->community_description;
	}

	/**
	 * @param string $community_description
	 * @return string
	 */
	public function setCommunityDescription($community_description) {
		$this->community_description = $community_description;

		return $this->community_description;
	}

	/**
	 * @return string
	 */
	public function getCommunityLogo() {
		return $this->community_logo;
	}

	/**
	 * @param string $community_logo
	 * @return string
	 */
	public function setCommunityLogo($community_logo) {
		$this->community_logo = $community_logo;

		return $this->community_logo;
	}

	/**
	 * @return string
	 */
	public function getCommunityUrl() {
		return $this->community_url;
	}

	/**
	 * @param string $community_url
	 * @return string
	 */
	public function setCommunityUrl($community_url) {
		$this->community_url = $community_url;

		return $this->community_url;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastFetched() {
		return $this->last_fetched;
	}

	/**
	 * @param \DateTime|string $last_fetched
	 * @return \DateTime
	 */
	public function setLastFetched($last_fetched) {
		if (is_string($last_fetched)) {
			$last_fetched = new \DateTime($last_fetched);
		}

		$this->last_fetched = $last_fetched;

		return $this->last_fetched;
	}

	/**
	 * @param FeedItem[] $feed_items
	 * @return FeedItem[]
	 */
	public function setFeedItems($feed_items) {
		$this->feed_items = $feed_items;

		return $this->feed_items;
	}

	/**
	 * @param FeedItem $feed_items
	 * @return FeedItem[]
	 */
	public function addFeedItem($feed_item) {
		array_push($this->feed_items, $feed_item);

		return $this->feed_items;
	}

	/**
	 * @return FeedItem[]
	 */
	public function getFeedItems() {
		return $this->feed_items;
	}
}
