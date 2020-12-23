<div class="editor">
  <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height" aria-hidden="true"></i>&nbsp;<b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
        <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
        <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
      </ul>
    </div>
    <div class="btn-group">
      <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold" aria-hidden="true"></i></a>
      <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic" aria-hidden="true"></i></a>
      <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough" aria-hidden="true"></i></a>
      <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline" aria-hidden="true"></i></a>
    </div>
    <div class="btn-group">
      <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left" aria-hidden="true"></i></a>
      <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center" aria-hidden="true"></i></a>
      <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right" aria-hidden="true"></i></a>
      <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify" aria-hidden="true"></i></a>
    </div>
  </div>

  <div id="editor">
    <?= ($isEdit) ? $model->text : '' ?>
  </div>
</div>
