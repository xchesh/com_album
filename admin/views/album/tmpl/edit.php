<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
$params = $this->form->getFieldsets('params');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task) {
        if (task == 'album.cancel' || document.formvalidator.isValid(document.id('album-form'))) {
            Joomla.submitform(task, document.getElementById('album-form'));
        }
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_album&layout=edit&id='.(int)$this->item->id); ?>" method="post" name="adminForm" id="album-form" class="form-validate">
    <div class="row-fluid">
        <div class="span12 form-horizontal">
            <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#general" data-toggle="tab">
                            <?php echo JText::_('COM_ALBUM_ALBUM_DETAILS');?>
                        </a>
                    </li>
                    <li>
                        <a href="#media" data-toggle="tab">
                            <?php echo JText::_('COM_ALBUM_ALBUM_MEDIA');?>
                        </a>
                    </li>
                    <li>
                        <a href="#media2" data-toggle="tab">
                            <?php echo JText::_('COM_ALBUM_ALBUM_MEDIA2');?>
                        </a>
                    </li>
                    <?php foreach ($params as $name => $fieldset): ?>
                            <li><a href="#params-<?php echo $name;?>" data-toggle="tab"><?php echo JText::_($fieldset->label);?></a></li>
                    <?php endforeach; ?>
                    <?php if ($this->canDo->get('core.admin')): ?>
                            <li><a href="#permissions" data-toggle="tab"><?php echo JText::_('COM_ALBUM_FIELDSET_RULES');?></a></li>
                    <?php endif ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="general">
                    <fieldset>
                        <?php foreach ($this->form->getFieldset('details') as $field): ?>
                            <div class="control-group">
                                <?php 
                                if ($field->fieldname!='amount'){
                                    echo $field->label;
                                    echo '<div class="controls">'.$field->input.'</div>'; 
                                }?>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </div>

                <?php foreach ($params as $name => $fieldset): ?>
                <div class="tab-pane" id="params-<?php echo $name;?>">
                    <?php if (isset($fieldset->description) && trim($fieldset->description)): ?>
                        <p class="tip"><?php echo $this->escape(JText::_($fieldset->description));?></p>
                    <?php endif;
                        foreach ($this->form->getFieldset($name) as $field): ?>
                            <div class="control-group">
                                <?php echo $field->label; ?>
                                <div class="controls">
                                    <?php echo $field->input; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <div class="tab-pane" id="media">
                    <div id="status">
                        <div id="view-panel" class="btn-group">
                            <span class="icon-grid-view btn btn-success"></span>
                            <span class="icon-list btn"></span>
                            <span class="icon-grid-view-2 btn"></span>
                        </div>
                        <div id="upload-panel">
                            
                        </div>
                    </div>
                    <div id="images">
                        <?php echo $this->form->getInput('amount'); ?>
                    </div>
                </div>
                <div class="tab-pane" id="media2">
                    <?php echo $this->form->getInput('video'); ?>
                </div>
                <?php if ($this->canDo->get('core.admin')): ?>
                    <div class="tab-pane" id="permissions">
                        <fieldset>
                            <?php echo $this->form->getInput('rules'); ?>
                        </fieldset>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <input type="hidden" name="task" value="album.edit" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </div>
</form>