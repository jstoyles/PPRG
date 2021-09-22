<?php
	class ReposModel{
		public static function getRepos(){
			global $db;
			return $db->select('github_popular_php_repos', [
					'id',
					'github_id',
					'github_name',
					'github_description'
				]
			);
		}

		public static function getRepo($id){
			global $db;
			return $db->select('github_popular_php_repos', [
					'id',
					'github_id',
					'github_name',
					'github_url',
					'github_created_date',
					'github_last_published_date',
					'github_description',
					'github_star_count',
				],
				['id'],
				[$id]
			);
		}

		public static function reset(){
			global $db;
			$db->query('TRUNCATE github_popular_php_repos');
			return 'Table Truncated';
		}

		public static function insert_repo(array $values){
			global $db;
			$db->insert('github_popular_php_repos', [
					'github_id',
					'github_name',
					'github_url',
					'github_created_date',
					'github_last_published_date',
					'github_description',
					'github_star_count'
				],
				$values
			);
			return 'Record Inserted';
		}
	}
?>