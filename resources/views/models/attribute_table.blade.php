


<table class="attribute-table">
	<?php if (!empty($caption)): ?>
		<caption><?= $caption ?></caption>
	<?php endif ?>
	<tbody>
		<?php
		foreach ($attributes as $attr): ?>
			<tr>
				<th class="right">
					<?= titlecase(($rel = $record->getRelation($attr)) ? $rel : $attr) ?>:
				</th>
				<td>
					<?php if ($rel = $record->getBelongsTo($attr)): ?>
						<a href="<?= $rel->getUrl() ?>">
							<?= $rel->getTitle($attr) ?>
						</a>
					<?php else: ?>
						<?= $record->getAttributeTitle($attr) ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
