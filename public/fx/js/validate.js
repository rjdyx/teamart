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
