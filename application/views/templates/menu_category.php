<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 22-Apr-19
 * Time: 13:48
 */
?>
<div class="cate-menu-list" id="accordionMenuCategory">
    <div class="container">
        <?php $index = 1;
        foreach ($categories as $category) : ?>
        <div class="cate-menu-item">
            <div class="cate-menu-item-title show" data-toggle="collapse" data-target="#collapse<?= $index ?>"
                 aria-expanded="false" aria-controls="collapse<?= $index ?>">
                <div><?= $category->name ?></div>
                <span class="icon-dropdown"></span>
            </div>
            <?php
            if (isset($category->children)) {
            ?>
            <div id="collapse<?= $index ?>" class="collapse sub-cate-menu-list" aria-labelledby="heading<?= $index ?>"
                 data-parent="#accordionMenuCategory">
                <div class="row sub-cate-menu-list-row">
                <?php
                foreach ($category->children as $child) {
                    foreach ($counts as $count) {
                        if ($count['id_subcatetegory'] == $child->id) {
                            if ($count['count']['Total'] !== 0) {
                                echo '<div class="col-md-4 sub-cate-menu-item d-flex align-items-center"><a href="' . base_url('show-category/conference/' . $child->parent_id . '/' . $child->id) . '" >' . $child->name . '<span class="quantity-number">' . $count['count']['Total'] . '</span></a></div>';
                            } else {
                                echo '<div class="col-md-4 sub-cate-menu-item d-flex align-items-center"><a href="' . base_url('show-category/conference/' . $child->parent_id . '/' . $child->id) . '" >' . $child->name . '</a></div>';
                            }
                        }
                    }
                }
                ?>
                </div>
                <div class="row sub-cate-menu-list-row">
                    <div class="col-md-4">
                        <div class="btn-custom btn-border green special"><a href="<?= base_url('available-conference/'  . $category->id) ?>">Available Conference</a></div>
                    </div>
                </div>
            </div>
                <?php } ?>
            </div>
            <?php $index++;
            endforeach; ?>
        </div>
    </div>
