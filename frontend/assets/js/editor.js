(function($) {
  $.fn.editor = function(settings) {
    var editor = this,
        options = $.extend({}, $.fn.editor.defaults, settings),
        selectedRange,
        toolbarBtnSelector,
        bindToolbar = function (toolbar, options) {
  				toolbar.find(toolbarBtnSelector).click(function () {
  					restoreSelection();
  					editor.focus();
  					execCommand($(this).data(options.commandRole));
  					saveSelection();
  				});
  				toolbar.find('[data-toggle=dropdown]').click(restoreSelection);

  				toolbar.find('input[type=text][data-' + options.commandRole + ']').on('webkitspeechchange change', function () {
  					var newValue = this.value; /* ugly but prevents fake double-calls due to selection restoration */
  					this.value = '';
  					restoreSelection();
  					if (newValue) {
  						editor.focus();
  						execCommand($(this).data(options.commandRole), newValue);
  					}
  					saveSelection();
  				}).on('focus', function () {
  					var input = $(this);
  					if (!input.data(options.selectionMarker)) {
  						markSelection(input, options.selectionColor);
  						input.focus();
  					}
  				}).on('blur', function () {
  					var input = $(this);
  					if (input.data(options.selectionMarker)) {
  						markSelection(input, false);
  					}
  				});
  				toolbar.find('input[type=file][data-' + options.commandRole + ']').change(function () {
  					restoreSelection();
  					if (this.type === 'file' && this.files && this.files.length > 0) {
  						insertFiles(this.files);
  					}
  					saveSelection();
  					this.value = '';
  				});
  			},
        updateToolbar = function () {
  				if (options.activeToolbarClass) {
  					$(options.toolbarSelector).find(toolbarBtnSelector).each(function () {
  						var command = $(this).data(options.commandRole);
  						if (document.queryCommandState(command)) {
  							$(this).addClass(options.activeToolbarClass);
  						} else {
  							$(this).removeClass(options.activeToolbarClass);
  						}
  					});
  				}
  			},
        execCommand = function (commandWithArgs, valueArg) {
  				var commandArr = commandWithArgs.split(' '),
  					command = commandArr.shift(),
  					args = commandArr.join(' ') + (valueArg || '');
  				document.execCommand(command, 0, args);
  				updateToolbar();
  			},
        getCurrentRange = function () {
  				var sel = window.getSelection();
  				if (sel.getRangeAt && sel.rangeCount) {
  					return sel.getRangeAt(0);
  				}
  			},
  			saveSelection = function () {
  				selectedRange = getCurrentRange();
  			},
  			restoreSelection = function () {
  				var selection = window.getSelection();
  				if (selectedRange) {
  					try {
  						selection.removeAllRanges();
  					} catch (ex) {
  						document.body.createTextRange().select();
  						document.selection.empty();
  					}

  					selection.addRange(selectedRange);
  				}
  			},
        markSelection = function (input, color) {
  				restoreSelection();
  				if (document.queryCommandSupported('hiliteColor')) {
  					document.execCommand('hiliteColor', 0, color || 'transparent');
  				}
  				saveSelection();
  				input.data(options.selectionMarker, color);
  			};



    toolbarBtnSelector = 'a[data-' + options.commandRole + '],button[data-' + options.commandRole + '],input[type=button][data-' + options.commandRole + ']';
    bindToolbar($(options.toolbarSelector), options);
		editor.attr('contenteditable', true)
			.on('mouseup keyup mouseout', function () {
				saveSelection();
				updateToolbar();
		});
    $(window).bind('touchend', function (e) {
			var isInside = (editor.is(e.target) || editor.has(e.target).length > 0),
				currentRange = getCurrentRange(),
				clear = currentRange && (currentRange.startContainer === currentRange.endContainer && currentRange.startOffset === currentRange.endOffset);
			if (!clear || isInside) {
				saveSelection();
				updateToolbar();
			}
		});
		return this;
  };

  $.fn.editor.defaults = {
		hotKeys: {
			'ctrl+b meta+b': 'bold',
			'ctrl+i meta+i': 'italic',
			'ctrl+u meta+u': 'underline',
			'ctrl+z meta+z': 'undo',
			'ctrl+y meta+y meta+shift+z': 'redo',
			'ctrl+l meta+l': 'justifyleft',
			'ctrl+r meta+r': 'justifyright',
			'ctrl+e meta+e': 'justifycenter',
			'ctrl+j meta+j': 'justifyfull',
			'shift+tab': 'outdent',
			'tab': 'indent'
		},
		toolbarSelector: '[data-role=editor-toolbar]',
		commandRole: 'edit',
		activeToolbarClass: 'btn-info',
		selectionMarker: 'edit-focus-marker',
		selectionColor: 'darkgrey',
	};
})(jQuery);
