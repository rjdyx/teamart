// import ajax from './ajax.js'
/**
 * 必需字段
 *
 * @param fieldtxt {string} 字段汉字名称
 * @param value {string} 字段值
 * @returns {boolean}
 */
const ness = (fieldtxt, value) => {
	if (value) {
		$('.form_error').text('')
		return true
	} else {
		$('.form_error').text(fieldtxt + '不能为空')
		return false
	}
}
exports.ness = ness

// 登录和注册
exports.checkField = (field, value, table, fieldtxt) => {
	if (!value) {
		return false
	}
	let params = {
		field: field,
		table: table,
		value: value
	}
	return axios.post('/check', params)
		.then(res => {
			if (res.data == 'false') {
				$('.form_error').text('')
				return true
			} else {
				$('.form_error').text(fieldtxt + '已经存在')
				return false
			}
		})
		.catch(err => {
			console.log(err)
		})
}

/**
 * 检查name
 *
 * @param fieldtxt {string} 字段汉字名称
 * @param value {string} 字段值
 * @param table {string} /check时的表名
 * @param isRequired {boolean} 是否必须
 * @returns {boolean}
 */
exports.name = (fieldtxt, value, isRequired = true) => {
	let valid = false, temp
	if (isRequired) {
		temp = ness(fieldtxt, value)
	}
	if (temp) {
		if (value.length < 4) {
			$('.form_error').text(fieldtxt + '不能少于4个字符')
			valid = false
		} else {
			$('.form_error').text('')
			valid = true
		}
	}
	return valid
}

exports.email = (value, isRequired = true) => {
	let valid = false, temp = true
	let reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+\.([a-zA-Z0-9_-])+/
	if (isRequired) {
		temp = ness('邮箱', value)
	}
	if (temp) {
		if (value.length > 0) {
			if (!reg.test(value)) {
				$('.form_error').text('邮箱格式不对')
				valid = false
			} else {
				$('.form_error').text('')
				valid = true
			}
		}
	}
	return valid
}

exports.password = (value, isRequired = true) => {
	let valid = false, temp = true
	if (isRequired) {
		temp = ness('密码', value)
	}
	if (temp) {
		if (value.length < 6 && value.length > 0) {
			$('.form_error').text('密码至少要6位')
			valid = false
		} else {
			$('.form_error').text('')
			valid = true
		}
	}
	return valid
}

exports.repassword = (value, isRequired = true) => {
	let valid = false, temp = true
	if (isRequired) {
		temp = ness('确认密码', value)
	}
	if (temp) {
		if (value.length < 6 && value.length > 0) {
			$('.form_error').text('确认密码至少要6位')
			valid = false
		} else {
			if ($('#password').val() !== value) {
				$('.form_error').text('两次密码不一致')
				valid = false
			} else {
				$('.form_error').text('')
				valid = true
			}
		}
	}
	return valid
}

exports.phone = (value, isRequired = true) => {
	let valid = false, temp = true
	if (isRequired) {
		temp = ness('手机', value)
	}
	if (value) {
		if (!/^1[34578]\d{9}$/.test(value)) {
			$('.form_error').text('手机格式不对')
			valid = false
		} else {
			$('.form_error').text('')
			valid = true
		}
	}
	return valid
}

// 唯一验证方法
exports.check = (field, value, table = 'user') => {
	let url = 'http://' + window.location.host + '/check'
	let params = {
		field: field,
		value: value,
		table: table
	}
	return ajax('post', url, params)
}

const necessary = ($inp, value) => {
	if (value) {
		$inp.parents('.form_item').removeClass('error')
		return true
	} else {
		$inp.parents('.form_item').addClass('error')
		return false
	}
}

const validate = {
	name: ($inp, value) => {
		if ($.trim(value).length < 2) {
			$inp.parents('.form_item').addClass('error')
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	email: ($inp, value) => {
		let reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+\.([a-zA-Z0-9_-])+/
		if (!reg.test(value)) {
			$inp.parents('.form_item').addClass('error')
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	phone: ($inp, value) => {
		if (!/^1[34578]\d{9}$/.test(value)) {
			$inp.parents('.form_item').addClass('error')
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	detail: ($inp, value) => {
		if ($.trim(value).length < 5) {
			$inp.parents('.form_item').addClass('error')
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	code: ($inp, value) => {
		if ($.trim(value).length > 0) {
			if (!/^[1-9][0-9]{5}$/.test(value)) {
				$inp.parents('.form_item').addClass('error')
			} else {
				$inp.parents('.form_item').removeClass('error')
			}
		}
	},
	address: ($inp, value) => {
		if ($.trim(value).length === 0) {
			$inp.parents('.form_item').addClass('error')
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	realname: ($inp, value) => {
		if ($.trim(value).length > 0) {
			if ($.trim(value).length < 2) {
				$inp.parents('.form_item').addClass('error')
			} else {
				$inp.parents('.form_item').removeClass('error')
			}
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	password: ($inp, value) => {
		if ($.trim(value).length > 0) {
			if ($.trim(value).length < 6) {
				$inp.parents('.form_item').addClass('error')
			} else {
				$inp.parents('.form_item').removeClass('error')
			}
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	},
	repassword: ($inp, value) => {
		if ($.trim(value).length > 0 || $.trim($('#password').val()).length > 0) {
			if ($.trim(value).length < 6) {
				$inp.parents('.form_item').addClass('error')
			} else {
				if ($('#password').val() !== value) {
					$inp.parents('.form_item').addClass('error')
				} else {
					$inp.parents('.form_item').removeClass('error')
				}
			}
		} else {
			$inp.parents('.form_item').removeClass('error')
		}
	}
}

exports.bindEvent = (fields) => {
	fields.forEach(v => {
		$('#' + v).on('input blur', function () {
			if ($(this).data('required')) {
				necessary($(this), $(this).val())
			}
			validate[v] && validate[v]($(this), $(this).val())
		})
	})
}

// 表单验证
exports.validForm = (params) => {
	let fields = Object.keys(params)
	fields.forEach(v => {
		let cinput, isRequired
		if (v === 'detail') {
			cinput = $(`textarea[name='${v}']`)
			isRequired = $(`textarea[name='${v}']`).data('required')
		} else {
			cinput = $(`input[name='${v}']`)
			isRequired = $(`input[name='${v}']`).data('required')
		}
		if (isRequired) {
			if (!necessary(cinput, params[v])) return
		}
		if (params[v]) {
			validate[v] && validate[v](cinput, params[v])
		}
	})
	if ($('.form_item.error').length > 0) {
		return false
	} else {
		return true
	}
}
