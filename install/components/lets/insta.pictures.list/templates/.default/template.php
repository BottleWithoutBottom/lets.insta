<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$pictures = $arResult['PICTURES'];
?>

<? if (!empty($pictures)): ?>
    <div class="instragram_feed">
        <?foreach ($pictures as $picture):
            $picturePath = $picture->thumbnail_url ?: $picture->media_url; ?>
        <div class="instragram_feed_item responsive_square">
            <a target="_blank" href="<?= $picture->permalink ?: 'javascript:void(0)' ?>" style="background-image: url('<?= $picturePath ?>')"></a>

            <div class="instagram_feed_item_svg">
                <?//    = svgIconSingle("instagram_white") ?>
            </div>

        </div>
    <? endforeach; ?>
    </div>
<? endif; ?>


