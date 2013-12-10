<?php
$js = NextendJavascript::getInstance();
$js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'slider.js');

$backgroundimage = $this->_sliderParams->get('simplebackgroundimage', '');
$backgroundimagecss = '';
if ($backgroundimage && $backgroundimage != '-1') $backgroundimagecss = 'background-image: url(' . $backgroundimage . ');';


$flux = (array)NextendParse::parse($this->_sliderParams->get('simplebackgroundanimation', '0|*|bars||blocks'));
$flux[0] = $this->_backend ? 0 : intval($flux[0]);
if (!isset($flux[1])) $flux[1] = 'bars';
$flux[1] = (array)$flux[1];
if ($flux[0]) {
    $js->addLibraryJsFile('jquery', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'flux.jquery.js');
}
?>
<script type="text/javascript">
    window['<?php echo $id; ?>-onresize'] = [];
</script>

<div id="<?php echo $id; ?>" class="<?php echo $sliderClasses; ?>" style="font-size: <?php echo intval($this->_sliderParams->get('globalfontsize', 14)); ?>px;">
    <div class="smart-slider-border1" style="<?php echo $backgroundimagecss . $this->_sliderParams->get('simpleslidercss', ''); ?>">
        <div class="smart-slider-border2">
            <?php if ($flux[0]): ?>
                <div class="nextend-flux">
                    <?php foreach ($this->_slides AS $slide): ?>
                        <?php if ($slide['bg']): ?>
                            <img src="<?php echo $slide['bg']; ?>" class="nextend-slide-bg"<?php if ($slide['first']) echo ' style="z-index:2;position: absolute; top: 0px; left: 0px;" '; ?>/>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php foreach ($this->_slides AS $slide): ?>
                <div class="<?php echo $slide['classes']; ?> smart-slider-bg-colored" style="<?php echo $slide['style']; ?>"<?php echo $slide['link']; ?>>
                    <?php if (!$this->_backend && !$flux[0] && $slide['bg']): ?>
                        <img src="<?php echo $slide['bg']; ?>" class="nextend-slide-bg"/>
                    <?php endif; ?>
                    <?php if ($this->_backend && strpos($slide['classes'], 'smart-slider-slide-active') !== false): ?>
                        <img src="<?php echo $slide['bg']; ?>" class="nextend-slide-bg"/>
                    <?php endif; ?>
                    <div class="smart-slider-canvas-inner">
                        <?php echo $slide['slide']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    $widgets->echoRemainder();
    ?>
</div>

<?php

$properties['type'] = 'ssSimpleSlider';
$properties['animation'] = explode('||', $this->_sliderParams->get('simpleanimation', 'no'));

$animationproperties = NextendParse::parse($this->_sliderParams->get('simpleanimationproperties', '1500|*|0|*|easeInOutQuint|*|0.45'));
$properties['animationSettings'] = array(
    'duration' => intval($animationproperties[0]),
    'delay' => intval($animationproperties[1]),
    'easing' => $animationproperties[2],
    'parallax' => floatval($animationproperties[3])
);

$properties['flux'] = $flux;

$properties['responsive']['maxwidth'] = intval($this->_sliderParams->get('fullpageresponsivemaxwidth', 3000));

?>
<script type="text/javascript">
    njQuery(document).ready(function () {
        njQuery('#<?php echo $id; ?>').smartslider(<?php echo json_encode($properties); ?>);
    });
</script>
<div style="clear: both;"></div>
