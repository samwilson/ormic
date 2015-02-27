


<table class="attribute-table">
	<?php if (!empty($caption)): ?>
		<caption><?= $caption ?></caption>
	<?php endif ?>
	<tbody>
		<?php
		foreach ($columns as $column): ?>
			<tr>
				<th class="right">
					<?= titlecase(($rel = $record->getRelation($column)) ? $rel : $column) ?>:
				</th>
				<td>
					<?php if ($rel = $record->getBelongsTo($column)): ?>
						<a href="<?= $rel->getUrl() ?>">
							<?= $rel->getTitle($column) ?>
						</a>
					<?php else: ?>
						<?= $record->getAttributeTitle($column) ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
