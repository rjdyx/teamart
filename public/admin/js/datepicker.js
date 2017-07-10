const zh = require('flatpickr/dist/l10n/zh.js').zh

module.exports = function datepicker (opts = {}) {
	opts.selector = opts.selector != undefined ? opts.selector : '#datepicker' // 选择器
	opts.enableTime = opts.enableTime != undefined ? opts.enableTime : false // 获取时间
	opts.disable = opts.disable != undefined ? opts.disable : true // 禁用时间
	opts.mode = opts.mode != undefined ? opts.mode : false // 模式
	opts.dateFormat = opts.dateFormat != undefined ? opts.dateFormat : 'Y-m-d' // 默认格式 'Y-m-d H:i:S'
	let config = {
		locale: zh,
		enableTime: opts.enableTime,
		dateFormat: opts.dateFormat
	}
	if (opts.disable) {
		if (opts.disableFn && typeof opts.disableFn === 'function') {
			config['disable'] = [opts.disableFn]
		} else {
			config['disable'] = [
				function (date) {
					return date.getTime() > Date.now()
				}
			]
		}
	}
	if (opts.mode) {
		config['mode'] = 'range'
	}
	if (opts.onChange && typeof opts.onChange === 'function') {
		config['onChange'] = opts.onChange
	}
	$(opts.selector).flatpickr(config)
}
