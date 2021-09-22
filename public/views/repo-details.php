<section>
	<p>
		<b>Github ID:</b><br />
		{{ $repo->github_id }}
	</p>
	<p>
		<b>Name:</b><br />
		{{ $repo->github_name }}
	</p>
	<p>
		<b>Creation Date:</b><br />
		<?php
			echo date('D., F jS, Y \a\t g:ia', strtotime($repo->github_created_date))
		?>
	</p>
	<p>
		<b>Last Published Date:</b><br />
		<?php
			echo date('D., F jS, Y \a\t g:ia', strtotime($repo->github_last_published_date))
		?>
	</p>
	<p>
		<b>Description:</b><br />
		{{ $repo->github_description }}
	</p>
	<p>
		<b>Star Count:</b><br />
		{{ echo number_format($repo->github_star_count); }}
	</p>
</section>