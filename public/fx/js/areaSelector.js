let AreaSelector = function () {
}
AreaSelector.prototype = {
	// 初始化
	init: function (opts) {
		this.trigger = opts.trigger
		this.txtTo = opts.txtTo
		this.valueTo = opts.valueTo
		this.data = opts.data
		this.eachNode(opts.data)
		this.selectEv()
		$('.J_region_cancel').on('tap', function () {
			$('.areaSelector').removeClass('top-0')
			$('.areaSelector_container').removeClass('bottom-0')
		})
		$('.J_region_submit').on('tap', function () {
			let txt = [], value = []
			$('.areaSelector_area').find('.active').each(function () {
				txt.push($(this).data('name'))
				value.push($(this).data('id'))
			})
			$('.areaSelector').removeClass('top-0')
			$('.areaSelector_container').removeClass('bottom-0')
			$(opts.txtTo).val(txt.join(','))
			$(opts.valueTo).val(value.join(','))
			$(opts.trigger).text(txt.join(',')).addClass('select')
			$(opts.trigger).parent().removeClass('error')
			if (txt.join(',').length > 10) {
				$(opts.trigger).addClass('fz-12')
			}
		})
		$(opts.trigger).on('tap', function () {
			$('.areaSelector').addClass('top-0')
			setTimeout(function () {
				$('.areaSelector_container').addClass('bottom-0')
			}, 0)
		})
	},
	// 递归遍历节点
	eachNode: function (data, level = 1) {
		let template = ''
		data.forEach((v, i) => {
			if (i === 0) {
				template += `<li class="active J_region_select" data-id="${v.value}" data-name="${v.text}" data-level="${level}" data-idx="${i}">${v.text}</li>`
				if (v.children) {
					this.eachNode(v.children, level + 1)
				}
			} else {
				template += `<li class="J_region_select" data-id="${v.value}" data-name="${v.text}" data-level="${level}" data-idx="${i}">${v.text}</li>`
			}
		})
		switch (level) {
		case 1:
			$('.area_list.province').html(template)
			break
		case 2:
			$('.area_list.city').html(template)
			break
		case 3:
			$('.area_list.area').html(template)
			break
		}
	},
	// 现在事件
	selectEv: function () {
		let self = this
		$('.J_region_select').off('tap').on('tap', function () {
			let level = parseInt($(this).data('level'))
			if (level === 1) {
				$('.area_list.city').html('').scrollTop(0)
				$('.area_list.area').html('').scrollTop(0)
				self.eachNode(self.data[$(this).data('idx')].children, parseInt($(this).data('level')) + 1)
			} else if (level === 2) {
				$('.area_list.area').html('').scrollTop(0)
				if (self.data[$('.province').find('.active').data('idx')].children[$(this).data('idx')].children) {
					self.eachNode(self.data[$('.province').find('.active').data('idx')].children[$(this).data('idx')].children, parseInt($(this).data('level')) + 1)
				}
			}
			$(this).addClass('active').siblings().removeClass('active')
			self.selectEv()
		})
	}
}

module.exports = AreaSelector
