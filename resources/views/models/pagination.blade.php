
<?php if ($paginator->currentPage() > 1 || $paginator->hasMorePages()): ?>

<ul class="button-group round">
    <li>
        <a <?php if ($paginator->currentPage() > 1) echo 'href="' . $paginator->url($paginator->currentPage() - 1) . '"' ?>
            class="tiny button">
            &lArr; Previous page
        </a>
    </li>
    <li>
        <a <?php if ($paginator->hasMorePages()) echo 'href="' . $paginator->url($paginator->currentPage() + 1) . '"' ?>
            class="tiny button">
            Next page &rArr;
        </a>
    </li>
</ul>

<?php endif ?>
