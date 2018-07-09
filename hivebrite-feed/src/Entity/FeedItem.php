<?php

namespace App\Entity;

class FeedItem
{
	/** @var string */
	private $type;

	/** @var \DateTime */
	private $published;

	/** @var string */
	private $title;

	/** @var string */
	private $body;

	/** @var string */
	private $url;

	/** @var array */
	private $meta;

	public function __construct()
    {
		$this->meta = [];
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return string
	 */
	public function setType($type) {
		$this->type = $type;

		return $this->type;
	}

	/**
	 * @return \DateTime
	 */
	public function getPublished() {
		return $this->published;
	}

	/**
	 * @param \DateTime|string $published
	 * @return \DateTime
	 */
	public function setPublished($published) {
		if (is_string($published)) {
			$published = new \DateTime($published);
		}

		$this->published = $published;

		return $this->published;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return string
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * @param string $body
	 * @return string
	 */
	public function setBody($body) {
		$this->body = $body;

		return $this->body;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 * @return string
	 */
	public function setUrl($url) {
		$this->url = $url;

		return $this->url;
	}

	/**
	 * @return array
	 */
	public function getMeta() {
		return $this->meta;
	}

	/**
	 * @param array $meta
	 * @return array
	 */
	public function setMeta($meta) {
		$this->meta = $meta;

		return $this->meta;
	}
}
