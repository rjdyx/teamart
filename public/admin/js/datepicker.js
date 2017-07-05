exports.datepicker = (opts = {}) => {
	opts.selector = opts.selector != undefined ? opts.selector : '#datepicker'
	opts.format = opts.format != undefined ? opts.format : 'yyyy-mm-dd'
	opts.endDate = opts.endDate != undefined ? opts.endDate : '0d'
	$(opts.selector).datepicker({
		language: 'zh-CN',
		format: opts.format,
		endDate: opts.endDate
	})
}
