<h1>Default Controller</h1>
<h2>pdo test view</h2>

<?php foreach ($rows as $i => $row): ?>
	<ul>
		<?php foreach ($row as $key => $value): ?>
			<li><?php echo "$key => $value"; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endforeach; ?>