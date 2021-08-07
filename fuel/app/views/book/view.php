<h2>Viewing <span class='muted'>#<?php echo $book->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $book->name; ?></p>
<p>
	<strong>Price:</strong>
	<?php echo $book->price; ?></p>
<p>
	<strong>Description:</strong>
	<?php echo $book->description; ?></p>

<?php echo Html::anchor('book/edit/'.$book->id, 'Edit'); ?> |
<?php echo Html::anchor('book', 'Back'); ?>