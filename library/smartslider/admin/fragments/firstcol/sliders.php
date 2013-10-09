<?php
$js = NextendJavascript::getInstance();


$accessModuleCreate = $this->canDo('core.create', 'com_modules');
$accessSliderCreate = $this->canDo('slider.create');
$accessSliderEdit = $this->canDo('slider.edit');
$accessSliderDelete = $this->canDo('slider.delete');
$accessSlideCreate = $this->canDo('slide.create');
$accessSlideEdit = $this->canDo('slide.edit');
$accessSlideDelete = $this->canDo('slide.delete');

$j15 = version_compare(JVERSION, '1.6.0', 'ge') || nextendIsWordPress() ? false : true;

$isJ = nextendIsJoomla();
$isWP = nextendIsWordPress();

if ($accessSliderCreate) :
    ?>
    <div class="smartslider-button-wrap">
        <div
            class="smartslider-button smartslider-createslider smartslider-button-grey smartslider-button-blue-active smartslider-icon-container <?php echo NextendRequest::getCmd('view') == 'sliders_slider' && NextendRequest::getCmd('action') == 'create' ? 'active' : ''; ?>">
            <a class="smartslider-button-link"
               href="<?php echo $this->route('controller=sliders&view=sliders_slider&action=create'); ?>"><span
                    class="smartslider-icon smartslider-icon-add"></span><?php echo NextendText::_('Create_slider'); ?></a>
        </div>
    </div>
<?php endif; ?>
<div style="clear: both;"></div>
<?php
$slidersModel = $this->getModel('sliders');
$sliders = $slidersModel->getSliders();
?>
<dl class="smartslider-list smartslider-sliders-list">
    <?php
    $sliderid = NextendRequest::getInt('sliderid');
    $i = 0;
    foreach ($sliders AS $slider):
        $c = $i % 2 ? 'even' : 'odd';
        $i++;
        $active = $sliderid == $slider['id'];

        $generator = json_decode($slider['generator'], true);
        if ($generator && isset($generator['enabled']) && $generator['enabled']) {
            $c .= ' nextend-slider-generator-enabled ';
        }

        ?>
        <dt class="<?php echo $c; ?> smartslider-button-blue-active smartslider-icon-container <?php echo $active ? 'subactive' : ''; ?> <?php echo $active && NextendRequest::getCmd('controller') == 'sliders' ? 'active' : ''; ?>">
            <a class="smartslider-button-link"
               href="<?php echo $this->route('controller=sliders&view=sliders_slider&action=edit&sliderid=' . $slider['id']); ?>"><?php echo $slider['title']; ?></a>
            <?php if ($accessSliderDelete): ?>
                <a onclick="return confirm('<?php echo NextendText::_('Are_you_sure_that_you_want_to_delete_the_slider_and_all_the_related_slides'); ?>')"
                   class="smartslider-icon smartslider-icon-trash nextend-element-hastip" title="<?php echo NextendText::_('Delete'); ?>"
                   href="<?php echo $this->route('controller=sliders&view=sliders_slider&action=delete&sliderid=' . $slider['id']); ?>">Delete
                    slider</a>
            <?php endif; ?>
            <?php if ($accessSliderCreate): ?>
                <a class="smartslider-icon smartslider-icon-duplicate nextend-element-hastip" title="<?php echo NextendText::_('Duplicate'); ?>"
                   href="<?php echo $this->route('controller=sliders&view=sliders_slider&action=duplicate&sliderid=' . $slider['id']); ?>">Duplicate
                    slider</a>
            <?php endif; ?>
            <?php if ($accessModuleCreate): ?>
                <a class="smartslider-icon smartslider-icon-module nextend-element-hastip" <?php if($isWP){ ?>onmouseenter="njQuery(this).qtip('api').set('hide.fixed', true);" onclick="return false;" <?php } ?>  title="<?php echo ($isWP ? htmlspecialchars('[smartslider2 slider="'.$slider['id'].'"]') : NextendText::_('Create_module')); ?>"
                   target="_blank"
                   href="<?php echo $isJ ? $this->route('controller=sliders&view=sliders_slider&action=createmodule&sliderid=' . $slider['id']) : ''; ?>#">Create
                    module from this slider</a>
            <?php endif; ?>
            <?php if ($accessSliderEdit): ?>
                <a class="smartslider-icon smartslider-icon-generator nextend-element-hastip"
                   title="<?php echo NextendText::_('Generator'); ?><?php if ($j15) echo NextendText::_('__Not_available_in_Joomla_15_Please_upgrade_your_Joomla') ?>"<?php if ($j15) echo ' onclick="return false;" ' ?>
                   href="<?php echo $this->route('controller=sliders&view=sliders_generator&action=generator&sliderid=' . $slider['id']); ?>">Create
                    or edit generator</a>
            <?php endif; ?>

            <?php if ($active && NextendRequest::getCmd('controller') != 'sliders'): ?>
                <span class="smartslider-arrowdown-border"></span>
                <span class="smartslider-arrowdown"></span>
            <?php endif; ?>
        </dt>
        <dd class="<?php echo $active ? 'active' : ''; ?>">
            <?php if ($sliderid == $slider['id']): ?>
                <?php
                $js->addLibraryJsLibraryFile('jquery', 'ui/jquery.ui.core.min.js');
                $js->addLibraryJsLibraryFile('jquery', 'ui/jquery.ui.widget.min.js');
                $js->addLibraryJsLibraryFile('jquery', 'ui/jquery.ui.mouse.min.js');
                $js->addLibraryJsLibraryFile('jquery', 'ui/jquery.ui.sortable.min.js');
                $js->addLibraryJsFile('jquery', NEXTEND_SMART_SLIDER2_ASSETS . 'admin/js/slideordering.js');

                $js->addInlineJs('njQuery(document).ready(function() { '
                . 'window.smartSliderSlideOrdering.init("' . $this->route('controller=slides&view=sliders_slides&action=order&sliderid=' . $slider['id']) . '"); '
                . '});');

                $js->addInlineJs('njQuery(document).ready(function() { '
                . ' '
                . '});');
                ?>
                <ul class="smartslider-slides-list">
                    <?php if ($accessSlideCreate) : ?>
                        <li class="smartslider-button-grey smartslider-button-blue-active smartslider-icon-container <?php echo NextendRequest::getCmd('view') == 'sliders_slides' && NextendRequest::getCmd('action') == 'create' ? 'active' : ''; ?>">
                            <a class="smartslider-button-link"
                               href="<?php echo $this->route('controller=slides&view=sliders_slides&action=create&sliderid=' . $sliderid); ?>">
                                <span class="smartslider-icon smartslider-icon-smalladd"></span>
                                <?php echo NextendText::_('Create_slide'); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $slidesModel = $this->getModel('slides');
                    $slides = $slidesModel->getSlides($sliderid);
                    $slideid = NextendRequest::getInt('slideid');
                    foreach ($slides AS $slide):
                        $activeslide = $slideid == $slide['id'];
                        ?>
                        <li id="slideorder_<?php echo $slide['id']; ?>"
                            class="smartslider-slide smartslider-icon-container smartslider-button-blue-active <?php echo $activeslide ? 'active' : ''; ?>">
                            <a class="smartslider-button-link"
                               href="<?php echo $this->route('controller=slides&view=sliders_slides&action=edit&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">
                                <span class="smartslider-icon smartslider-icon-ordering"></span>
                                <?php echo $slide['title']; ?>
                            </a>
                            <?php if ($accessSlideDelete) : ?>
                                <a onclick="return confirm('Are you sure that you want to delete the slide?')"
                                   class="smartslider-icon smartslider-icon-trash nextend-element-hastip" title="<?php echo NextendText::_('Delete'); ?>"
                                   href="<?php echo $this->route('controller=slides&view=sliders_slides&action=delete&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">Delete
                                    slide</a>
                            <?php endif; ?>
                            <?php if ($accessSlideEdit) : ?>
                                <a class="smartslider-icon smartslider-icon-duplicate nextend-element-hastip"
                                   title="<?php echo NextendText::_('Duplicate'); ?>"
                                   href="<?php echo $this->route('controller=slides&view=sliders_slides&action=duplicate&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">Duplicate
                                    slide</a>
                                <?php if ($slide['first']): ?>
                                    <a class="smartslider-icon smartslider-icon-starred nextend-element-hastip"
                                       title="<?php echo NextendText::_('First_slide'); ?>"
                                       href="<?php echo $this->route('controller=slides&view=sliders_slides&action=first&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">First
                                        slide</a>
                                <?php else: ?>
                                    <a class="smartslider-icon smartslider-icon-star nextend-element-hastip"
                                       title="<?php echo NextendText::_('Click_to_set_first'); ?>"
                                       href="<?php echo $this->route('controller=slides&view=sliders_slides&action=first&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">Set
                                        first slide</a>
                                <?php endif; ?>
                                <?php if ($slide['published']): ?>
                                    <a class="smartslider-icon smartslider-icon-published nextend-element-hastip"
                                       title="<?php echo NextendText::_('Published__click_to_unpublish'); ?>"
                                       href="<?php echo $this->route('controller=slides&view=sliders_slides&action=unpublish&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">Click
                                        to unpublish slide</a>
                                <?php else: ?>
                                    <a class="smartslider-icon smartslider-icon-unpublished nextend-element-hastip"
                                       title="<?php echo NextendText::_('Unpublished__click_to_publish'); ?>"
                                       href="<?php echo $this->route('controller=slides&view=sliders_slides&action=publish&sliderid=' . $slider['id'] . '&slideid=' . $slide['id']); ?>">Click
                                        to publish slide</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>

            <?php endif; ?>
        </dd>
    <?php
    endforeach;
    ?>
</dl>