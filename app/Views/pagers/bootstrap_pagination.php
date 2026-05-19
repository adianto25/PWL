<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($pager->hasPreviousPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>#kulinerSection" aria-label="Previous">
                    <span aria-hidden="true">Sebelumnya</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Sebelumnya</span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>#kulinerSection">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage() ?>#kulinerSection" aria-label="Next">
                    <span aria-hidden="true">Selanjutnya</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">Selanjutnya</span>
            </li>
        <?php endif ?>
    </ul>
</nav>
