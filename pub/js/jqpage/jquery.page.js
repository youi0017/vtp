(function($) {
	var defaults = {
		totalPages: 9,
		liNums: 9,
		activeClass: 'active',
		firstPage: '首页',
		lastPage: '末页',
		prv: '«',
		next: '»',
		hasFirstPage: true,
		hasLastPage: true,
		hasPrv: true,
		hasNext: true,
		callBack: function(page) {}
	};
	$.fn.Page = function(options) {
		var opts = $.extend(defaults, options);
		return this.each(function() {
			var obj = $(this);
			var l = opts.totalPages;
			var n = opts.liNums;
			var active = opts.activeClass;
			var str = '';
			var str1 = '<li><a href="javascript:" class="' + active + '">1</a></li>';
			if (l > 1 && l < n + 1) {
				for (i = 2; i < l + 1; i++) {
					str += '<li><a href="javascript:">' + i + '</a></li>';
				}
			} else if (l > n) {
				for (i = 2; i < n + 1; i++) {
					str += '<li><a href="javascript:">' + i + '</a></li>';
				}
			}
			var dataHtml = '';
			if (opts.hasNext) {
				dataHtml += '<div class="next fr">' + opts.next + '</div>';
			}
			if (opts.hasLastPage) {
				dataHtml += '<div class="last fr">' + opts.lastPage + '</div>';
			}
			dataHtml += '<ul class="pagingUl">' + str1 + str + '</ul>';
			if (opts.hasFirstPage) {
				dataHtml += '<div class="first fr">' + opts.firstPage + '</div>';
			}
			if (opts.hasPrv) {
				dataHtml += '<div class="prv fr">' + opts.prv + '</div>';
			}
			obj.html(dataHtml).off("click");
			obj.on('click', '.next', function() {
				var pageshow = parseInt($('.' + active).html());
				var nums, flag;
				var a = n % 2;
				if (a == 0) {
					nums = n;
					flag = true;
				} else if (a == 1) {
					nums = (n + 1);
					flag = false;
				}
				if (pageshow >= l) {
					return;
				} else if (pageshow > 0 && pageshow <= nums / 2) {
					$('.' + active).removeClass(active).parent().next().find('a').addClass(active);
				} else if ((pageshow > l - nums / 2 && pageshow < l && flag == false) || (pageshow > l - nums / 2 - 1 && pageshow < l && flag == true)) {
					$('.' + active).removeClass(active).parent().next().find('a').addClass(active);
				} else {
					$('.' + active).removeClass(active).parent().next().find('a').addClass(active);
					fpageShow(pageshow + 1);
				}
				opts.callBack(pageshow + 1);
			});
			obj.on('click', '.prv', function() {
				var pageshow = parseInt($('.' + active).html());
				var nums = odevity(n);
				if (pageshow <= 1) {
					return;
				} else if ((pageshow > 1 && pageshow <= nums / 2) || (pageshow > l - nums / 2 && pageshow < l + 1)) {
					$('.' + active).removeClass(active).parent().prev().find('a').addClass(active);
				} else {
					$('.' + active).removeClass(active).parent().prev().find('a').addClass(active);
					fpageShow(pageshow - 1);
				}
				opts.callBack(pageshow - 1);
			});
			obj.on('click', '.first', function() {
				var activepage = parseInt($('.' + active).html());
				if (activepage <= 1) {
					return
				}
				opts.callBack(1);
				fpagePrv(0);
			});
			obj.on('click', '.last', function() {
				var activepage = parseInt($('.' + active).html());
				if (activepage >= l) {
					return;
				}
				opts.callBack(l);
				if (l > n) {
					fpageNext(n - 1);
				} else {
					fpageNext(l - 1);
				}
			});
			obj.on('click', 'li', function() {
				var $this = $(this);
				var pageshow = parseInt($this.find('a').html());
				var nums = odevity(n);
				opts.callBack(pageshow);
				if (l > n) {
					if (pageshow > l - nums / 2 && pageshow < l + 1) {
						fpageNext((n - 1) - (l - pageshow));
					} else if (pageshow > 0 && pageshow < nums / 2) {
						fpagePrv(pageshow - 1);
					} else {
						fpageShow(pageshow);
					}
				} else {
					$('.' + active).removeClass(active);
					$this.find('a').addClass(active);
				}
			});

			function fpageShow(activePage) {
				var nums = odevity(n);
				var pageStart = activePage - (nums / 2 - 1);
				var str1 = '';
				for (i = 0; i < n; i++) {
					str1 += '<li><a href="javascript:" class="">' + (pageStart + i) + '</a></li>'
				}
				obj.find('ul').html(str1);
				obj.find('ul li').eq(nums / 2 - 1).find('a').addClass(active);
			}

			function fpagePrv(index) {
				var str1 = '';
				if (l > n - 1) {
					for (i = 0; i < n; i++) {
						str1 += '<li><a href="javascript:" class="">' + (i + 1) + '</a></li>'
					}
				} else {
					for (i = 0; i < l; i++) {
						str1 += '<li><a href="javascript:" class="">' + (i + 1) + '</a></li>'
					}
				}
				obj.find('ul').html(str1);
				obj.find('ul li').eq(index).find('a').addClass(active);
			}

			function fpageNext(index) {
				var str1 = '';
				if (l > n - 1) {
					for (i = l - (n - 1); i < l + 1; i++) {
						str1 += '<li><a href="javascript:" class="">' + i + '</a></li>'
					}
					obj.find('ul').html(str1);
					obj.find('ul li').eq(index).find('a').addClass(active);
				} else {
					for (i = 0; i < l; i++) {
						str1 += '<li><a href="javascript:" class="">' + (i + 1) + '</a></li>'
					}
					obj.find('ul').html(str1);
					obj.find('ul li').eq(index).find('a').addClass(active);
				}
			}

			function odevity(n) {
				var a = n % 2;
				if (a == 0) {
					return n;
				} else if (a == 1) {
					return (n + 1);
				}
			}
		});
	}
})(jQuery);