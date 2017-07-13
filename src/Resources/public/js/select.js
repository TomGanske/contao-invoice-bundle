;
(function($, undefined) {
	$.fn.vselect = function(settings) {
		var run = $.type(settings) === 'string',
			args = [].slice.call(arguments, 1);
		if (!this.length) return;
		if (run && settings === 'value') {
			if (args.length) {
				return this.each(function() {
					var instance = $(this).data('mimic');
					instance && vselect.prototype.setValue.apply(instance, args);
				});
			} else {
				var instance = $(this[0]).data('mimic');
				return instance ? vselect.prototype.getValue.apply(instance) : undefined;
			}
		}
		return this.each(function() {
			var $element = $(this);
			var instance = $element.data('mimic');
			if (run && settings.charAt(0) !== '_' && instance) {
				vselect.prototype[settings] && vselect.prototype[settings].apply(instance, args);
			} else if (!run && !instance) {
				var instance = new vselect($element, settings);
				instance._init();
				$element.data('mimic', instance);
			}
		});
	};
	//**************************************************************************************************************
	// 构造函数
	var vselect = function($element, settings) {
		this.options = $.extend({}, this.options, settings);
		this.elem = {
			win: $(window),
			doc: $(document),
			body: $(document.body),
			mimic: $element
		};
		this.elem.option = this.elem.mimic.find('#vs-option');
		this.elem.scroll = this.elem.option.children();
		this.elem.items = this.elem.scroll.children();
		//var t = new Date();
		//this.elem.item = this.elem.items.children();
		this.elem.item = this.elem.items.find('div');
		//alert(new Date().getTime() - t);
		// 下拉菜单显示状态，初始状态是显示的
		this.show = true;
		// 下拉菜单是否有滚动条
		this.scroll = false;
		// 禁用状态，初始状态根据mimic的class决定
		this.disabled = this.elem.mimic.hasClass('vs-disabled');
		// 当前选中项的索引，初始状态根据item的id决定，如无选中项则选中第一个，选项为空index=-1
		this.index = this.elem.option.find('#vs-selected').index();
		this.index = (this.index < 0 && this.elem.item.length) ? 0 : this.index;
		// option位置缓存
		this.position = {};
		this.effect = 'slideDown';
		this._updateOptions();
	};
	//**************************************************************************************************************
	// 配置参数
	vselect.prototype.options = {
		// 主题风格
		theme: 'default',
		// 下拉菜单不出现滚动条最大选项个数
		size: 10,
		// item的高度，提高效率
		//小于0时自动检测
		mimicOuterHeight: 28,
		mimicInnerHeight: 26,
		mimicWidthPatch: 42,
		optionWidthPatch: 22,
		optionHeightPatch: 2,
		itemOuterHeight: 24,
		itemWidthPatch: 20,
		// 美化节点宽度
		width: 'auto',
		// 键盘选择是否可循环
		loop: false,
		//width:300,
		// 下拉过程是否有动画效果
		animate: true,
		// 下拉过程动画时长（毫秒）
		durationShow: 100,
		// 收起过程动画时长（毫秒）
		durationHide: 100
	};
	//**************************************************************************************************************
	// 初始化
	vselect.prototype._init = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		// 将option转移到body尾部
		$elem.option.addClass('vui-select-option-' + opts.theme).appendTo($elem.body);
		// item事件
		$elem.option.on('mouseup', '.vs-item', function(e) {
			$this._selected($(this).index());
		}).on('mouseover', '.vs-item', function() {
			$(this).addClass('vs-item-hover');
		}).on('mouseout', '.vs-item', function() {
			$(this).removeClass('vs-item-hover');
		}).on('keydown', function(e) {
			e.preventDefault();
			$this._keyboard.call($this, e);
		});
		// mimic事件
		$elem.mimic.on('mousedown', function(e) {
			$this._toggle();
		}).on('mouseenter', function() {
			$(this).addClass('vs-hover');
		}).on('mouseleave', function() {
			$(this).removeClass('vs-hover');
		}).on('keydown', function(e) {
			e.preventDefault();
			$this._keyboard.call($this, e);
		}).addClass('vui-select-' + opts.theme);
		// document事件
		$elem.doc.on('click', function(e) {
			if ($this.show && !$(e.target).closest('.vs-select').is($elem.mimic)) {
				$this._hide();
			}
		});
		// window事件
		$elem.win.on('scroll resize', function() {
			if ($this.show) {
				$this._setPos();
			}
		});
		// 禁用选中
		$this._disableSelection($elem.mimic);
		$this._disableSelection($elem.option);
		// 初始化尺寸
		$this._setSize();
		// 初始化位置
		$this._setPos();
		// 隐藏下拉菜单
		$this._hide(true);
		// 取消临时隐藏
		$elem.option.css({
			visibility: 'visible'
		});
		// 选中默认
		$this._selected($this.index, true);
	};
	//**************************************************************************************************************
	// 更新选项
	vselect.prototype._updateOptions = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		$.each(opts, function(i, n) {
			var value = $elem.mimic.attr('data-' + i);
			if (value === 'true' || value === 'false') {
				opts[i] = value === 'true' ? true : false;
			} else if ($.isNumeric(value)) {
				opts[i] = parseInt(value, 10);
			} else if (typeof(value) === 'string' && value !== '') {
				opts[i] = value;
			}
		});
	};
	//**************************************************************************************************************
	// 获取选中值
	vselect.prototype.getValue = function() {
		return this.index >= 0 ? this.elem.item.eq(this.index).attr('data-value') : null;
	};
	//**************************************************************************************************************
	// 设置选中值
	vselect.prototype.setValue = function(value) {
		this._selected(this.elem.item.filter('[data-value="' + value + '"]').index(), true);
	};
	//**************************************************************************************************************
	// 插入选项
	vselect.prototype.add = function() {
		var $this = this,
			$elem = $this.elem,
			items, $item, first;
		if ($.isArray(arguments[0])) {
			items = arguments[0];
			clear = arguments[1]; // 插入前删除原来的选项
			first = arguments[2]; // 从前插入
		} else {
			items = [
				[arguments[0], arguments[1]]
			];
			clear = arguments[2];
			first = arguments[3];
		}
		if (clear) {
			$elem.items.empty();
		}
		for (var i = 0; i < items.length; i++) {
			$item = $('<div data-value="' + items[i][1] + '" class="vs-item">' + items[i][0] + '</div>');
			if (first) {
				$elem.items.prepend($item);
			} else {
				$elem.items.append($item);
			}
		}
		$elem.item = $elem.items.find('div');
		var disabled = $this.disabled;
		$this.disabled = false;
		$elem.option.css({
			visibility: 'hidden'
		});
		$this._show(true);
		$this._setSize();
		$this._hide(true);
		$elem.option.css({
			visibility: 'visible'
		});
		$this.disabled = disabled;
		$this._selected($item.index(), true);
	};
	//**************************************************************************************************************
	// 删除选项
	vselect.prototype.remove = function(value, type) {
		var $this = this,
			$elem = $this.elem;
		switch (type) {
		case 1:
			// 通过文本内容删除
			$elem.item.each(function() {
				var $the = $(this);
				if ($the.text() == value) {
					$the.remove();
				}
			});
			break;
		case 2:
			// 通过索引删除， 当索引小于0时，删除当前选中项
			value = value < 0 ? $this.index : value;
			$elem.item.eq(value).remove();
			break;
		default:
			// 通过value删除
			$elem.item.filter('[data-value="' + value + '"]').remove();
		};
		$elem.item = $elem.items.find('div');
		if ($this.index >= $elem.item.length) {
			$this.index = $elem.item.length - 1;
		}
		var disabled = $this.disabled;
		$this.disabled = false;
		$elem.option.css({
			visibility: 'hidden'
		});
		$this._show(true);
		$this._setSize();
		$this._hide(true);
		$elem.option.css({
			visibility: 'visible'
		});
		$this.disabled = disabled;
		$this._selected($this.index, true);
	};
	//**************************************************************************************************************/
	// 设置禁用状态
	vselect.prototype.disabled = function(value) {
		this.disabled = value;
		this.elem.mimic.toggleClass('vs-disabled', value);
		this._hide();
	};
	//**************************************************************************************************************
	// 显示下拉菜单
	vselect.prototype._show = function(noAnimate) {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		if (!$this.show && !$this.disabled && $elem.item.length) {
			$elem.mimic.addClass('vs-focus');
			$this.show = true;
			if (false === opts.animate || noAnimate) {
				$elem.option.show();
				$this._setPos();
				$this._fixed();
			} else {
				$elem.option.stop();
				$this._setPos();
				$elem.option[this.effect]({
					duration: opts.durationShow,
					queue: false,
					done: function() {
						$this._fixed();
					}
				});
			}
		}
	};
	//**************************************************************************************************************
	// 隐藏下拉菜单
	vselect.prototype._hide = function(noAnimate) {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		if ($this.show) {
			$elem.mimic.removeClass('vs-focus');
			$this.show = false;
			if (false === opts.animate || noAnimate) {
				$elem.option.hide();
			} else {
				$elem.option.stop().fadeOut({
					duration: opts.durationHide,
					queue: false
				});
			}
		}
	};
	//**************************************************************************************************************
	// 显示或隐藏下拉菜单
	vselect.prototype._toggle = function() {
		if (this.show) {
			this._hide();
		} else {
			this._show();
		}
	};
	//**************************************************************************************************************
	// 选中行为
	vselect.prototype._selected = function(index, noChange) {
		var $this = this,
			$elem = $this.elem;
		// 判断是否触发change事件
		var change = $this.index !== index;
		// 清除原来选项的选中状态
		$elem.item.removeClass('vs-selected');
		// 设置当前选项选中状态和mimic文本
		if (index >= 0) {
			var $selected = $elem.item.eq(index).addClass('vs-selected');
			$elem.mimic.find('.vs-title>.vs-text').text($($selected).text());
		} else {
			$elem.mimic.find('.vs-title>.vs-text').text('');
		}
		// 同步当前选中值
		$this.index = index;
		// 保证被选中选项在可视范围内
		$this._fixed();
		// 触发change事件
		if (change && !noChange) {
			$elem.mimic.trigger('change');
		}
	};
	//**************************************************************************************************************
	// 选中下一个
	vselect.prototype._next = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		if ($elem.item.length) {
			var index = $this.index + 1;
			if (index >= $elem.item.length) {
				if (opts.loop) {
					index = 0;
				} else {
					return;
				}
			}
			$this._selected(index);
		}
	};
	//**************************************************************************************************************
	// 选中上一个
	vselect.prototype._prev = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		if ($elem.item.length) {
			var index = $this.index - 1;
			if (index < 0) {
				if (opts.loop) {
					index = $elem.item.length - 1;
				} else {
					return;
				}
			}
			$this._selected(index);
		}
	}
	//**************************************************************************************************************
	// 键盘事件
	vselect.prototype._keyboard = function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == 38) {
			this._prev();
		} else if (keycode == 40) {
			this._next();
		}
	};
	//**************************************************************************************************************
	// 保证选中项在下拉菜单可视范围
	vselect.prototype._fixed = function() {
		if (this.show && this.scroll && this.index >= 0) {
			//	console.log('fixed');
			var ItemOuterHeight = this._getItemOuterHeight();
			var scrollTop = this.elem.scroll.scrollTop();
			if (this.index * ItemOuterHeight < scrollTop) {
				this.elem.scroll.scrollTop(this.index * ItemOuterHeight);
			} else if ((this.index + 1) * ItemOuterHeight > scrollTop + this.options.size * ItemOuterHeight) {
				this.elem.scroll.scrollTop((this.index - this.options.size + 1) * ItemOuterHeight);
			}
		}
	};
	//**************************************************************************************************************
	vselect.prototype._setSize = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		if ($elem.item.length <= 0 || false === $this.show) {
			return;
		}
		$elem.items.removeClass('vs-block');
		// mimic默认宽度
		var mimicTextWidth = opts.width === 'auto' ? 0 : opts.width;
		// 按钮宽度的补丁，默认42
		if (opts.mimicWidthPatch < 0) {
			opts.mimicWidthPatch = $elem.mimic.outerWidth() - mimicTextWidth;
		}
		var mimicWidthPatch = opts.mimicWidthPatch; //0
		// 单个选项高度，默认24
		var itemOuterHeight = $this._getItemOuterHeight(); //0
		// 选项外框宽度，需要渲染占用大量资源
		var itemsWidth = $elem.items.width(); //1500
		// 单个选项补丁宽度，默认20
		var itemWidthPatch = $this._getItemWidthPatch(); //0
		// 单个选项宽度
		var itemWidth = itemsWidth - itemWidthPatch; //0
		// 获取option补丁宽度，默认22
		if (opts.optionWidthPatch < 0) {
			opts.optionWidthPatch = $elem.option.outerWidth() - itemWidth;
		}
		var optionWidthPatch = opts.optionWidthPatch; //0
		// 是否有滚动条，计算滚动条宽度
		var scrollWidth = 0;
		if ($elem.item.length > opts.size) {
			$elem.scroll.css({
				height: itemOuterHeight * opts.size,
				overflowY: 'scroll'
			});
			$this.scroll = true;
			scrollWidth = 16;
			optionWidthPatch += scrollWidth;
		} else {
			if ($this.scroll) {
				//console.log('123');
				$elem.scroll.css({
					height: 'auto',
					overflowY: 'hidden'
				});
				$this.scroll = false;
			}
		} //70
		// mimic和option补丁宽度差值
		var patchDiff = Math.abs(mimicWidthPatch - optionWidthPatch); //0
		var textWidth = Math.max(mimicTextWidth, itemWidth);
		mimicTextWidth = opts.width === 'auto' ? (textWidth + (mimicWidthPatch >= optionWidthPatch ? 0 : patchDiff)) : opts.width;
		// 设置mimic的文本节点宽度
		$elem.mimic.find('.vs-title>.vs-text').width(mimicTextWidth); //0
		// 设置option的滚动节点宽度
		$elem.scroll.width(textWidth + itemWidthPatch + (mimicWidthPatch <= optionWidthPatch ? 0 : patchDiff) + scrollWidth); //70
		// 让选项自动宽度
		$elem.items.addClass('vs-block'); //90
	};
	//**************************************************************************************************************
	// 设置模拟下拉菜单位置
	vselect.prototype._setPos = function() {
		var $this = this,
			$elem = $this.elem,
			opts = $this.options;
		// mimic outer height
		if (opts.mimicOuterHeight < 0) {
			opts.mimicOuterHeight = $elem.mimic.outerHeight();
		}
		var mimicOuterHeight = opts.mimicOuterHeight;
		// mimic inner height
		if (opts.mimicInnerHeight < 0) {
			opts.mimicInnerHeight = $elem.mimic.innerHeight();
		}
		var mimicInnerHeight = opts.mimicInnerHeight;
		// option height patch
		if (opts.optionHeightPatch < 0) {
			opts.optionHeightPatch = $elem.option.outerHeight() - $elem.items.height();
		}
		var optionHeightPatch = opts.optionHeightPatch;
		// item outer height
		var itemOuterHeight = $this._getItemOuterHeight();
		// option outer height
		var optionOuterHeight = ($elem.item.length > opts.size ? opts.size : $elem.item.length) * itemOuterHeight + optionHeightPatch;
		// mimic to document top
		var mimicOffsetTop = $elem.mimic.offset().top; //175
		// mimic to window top
		var upper = mimicOffsetTop - $elem.win.scrollTop();
		// mimic to window bottom
		var below = $elem.win.height() - upper - mimicOuterHeight;
		// 模拟按钮节点到浏览器底部距离小于模拟下拉菜单高度 并且 模拟按钮节点到浏览器顶部距离大于模拟下拉菜单高度 时 模拟下拉菜单在模拟按钮上方出现，否则在下方出现
		// 上方出现时不开启动画
		var top, left;
		left = $elem.mimic.offset().left;
		if (below < optionOuterHeight && upper >= optionOuterHeight) {
			// 下拉菜单到页面顶端距离 等于 模拟按钮到页面顶端距离 减去 下拉菜单高度 加上 单条下拉菜单边框高度
			top = mimicOffsetTop - optionOuterHeight + (mimicOuterHeight - mimicInnerHeight) / 2;
			$this.effect = 'fadeIn';
		} else {
			top = mimicOffsetTop + mimicOuterHeight - (mimicOuterHeight - mimicInnerHeight) / 2;
			$this.effect = 'slideDown';
		}
		if (top !== $this.position.top || left !== $this.position.left) {
			$elem.option.css({
				'top': top,
				'left': left
			});
			$this.position.top = top;
			$this.position.left = left;
		}
	};
	//**************************************************************************************************************
	// 获取单个选项完整高度
	vselect.prototype._getItemOuterHeight = function() {
		if (this.options.itemOuterHeight < 0) {
			this.options.itemOuterHeight = this.elem.item.eq(0).outerHeight(true);
		}
		return this.options.itemOuterHeight;
	};
	//**************************************************************************************************************
	// 获取单个选项补丁宽度
	vselect.prototype._getItemWidthPatch = function() {
		if (this.options.itemWidthPatch < 0 && this.elem.item.length) {
			var $item = this.elem.item.eq(0);
			this.options.itemWidthPatch = $item.outerWidth(true) - $item.width();
		}
		return this.options.itemWidthPatch < 0 ? 0 : this.options.itemWidthPatch;
	};
	//**************************************************************************************************************
	// 禁用选中
	vselect.prototype._disableSelection = function(elements) {
		elements.css('MozUserSelect', 'none').attr('unselectable', 'on').on('selectstart', function() {
			return false;
		});
	};
})(jQuery);