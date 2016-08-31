<?php 


class Socialmedia extends Model{


	public function get_facebook_link(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."socialmedia WHERE social_media='facebook'");

		$row = $result->fetchObject();

		return $row->link;
	}

	public function get_twitter_link(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."socialmedia WHERE social_media='twitter'");

		$row = $result->fetchObject();

		return $row->link;
	}


		public function get_instagram_link(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."socialmedia WHERE social_media='instagram'");

		$row = $result->fetchObject();

		return $row->link;
	}


	public function get_youtube_link(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."socialmedia WHERE social_media='youtube'");

		$row = $result->fetchObject();

		return $row->link;
	}



}


?>