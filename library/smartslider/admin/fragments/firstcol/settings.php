<?php
$action = NextendRequest::getCmd('action', 'default');
$settings = array(
    array('id' => 'default', 'title' => NextendText::_('General_settings')),
    array('id' => 'layout', 'title' => NextendText::_('Layout_settings')),
    array('id' => 'font', 'title' => NextendText::_('Font_settings'))
);
if(nextendIsJoomla()){
    $settings[] = array('id' => 'joomla', 'title' => NextendText::_('Joomla_settings'));
}
?>
<dl class="smartslider-list smartslider-sliders-list">
    <?php
    $i = 0;
    foreach ($settings AS $setting):
        $c = $i % 2 ? 'even' : 'odd';
        $i++;
        $active = $action == $setting['id'];
        ?>
        <dt class="<?php echo $c; ?> smartslider-button-blue-active smartslider-icon-container <?php echo $active ? 'active' : ''; ?>">
        <a class="smartslider-button-link" href="<?php echo $this->route('controller=settings&view=sliders_settings&action=' . $setting['id']); ?>"><?php echo $setting['title']; ?></a>
        </dt>
        <dd style="display: none;"></dd>
        <?php
    endforeach;
    ?>
</dl>