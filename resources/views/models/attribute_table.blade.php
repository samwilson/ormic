


<table class="attribute-table">
	<?php if (!empty($caption)): ?>
		<caption><?= $caption ?></caption>
	<?php endif ?>
	<tbody>
		<?php
		$timestamps = array(\Illuminate\Database\Eloquent\Model::CREATED_AT, \Illuminate\Database\Eloquent\Model::UPDATED_AT);
		foreach (array_diff($attributes, $timestamps) as $attr): ?>
			<tr>
				<th class="right">
					<?= titlecase(($rel = $record->getRelation($attr)) ? $rel : $attr) ?>:
				</th>
				<td>
					<?php if ($rel = $record->getRelation($attr)): ?>
						<a href="<?= $record->$rel->getUrl() ?>">
							<?= $record->getAttributeTitle($attr) ?>
						</a>
					<?php else: ?>
						<?= $record->getAttributeTitle($attr) ?>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
		<?php if (array_intersect($timestamps, $attributes)): ?>
			<tr class="timestamps">
				<td colspan="2">
					&middot;
					Created: <?=$record->created_at?>
					&middot;
					Updated: <?=$record->updated_at?>
					&middot;
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>
