const required = (field, fieldtxt, value) => {
	if (value) {
		$('#' + field + '_txt').text('')
		return true
	} else {
		$('#' + field + '_txt').text(fieldtxt + '不能为空')
		return false
	}
}

exports.required = required

exports.name = (field, fieldtxt, value, table, isRequired = true) => {
	let valid = false, temp
	if (isRequired) {
		temp = required(field, fieldtxt, value)
	}
	if (temp) {
		if (value.length < 4) {
			$('#' + field + '_txt').text(fieldtxt + '不能少于4个字符')
			valid = false
		} else {
			let id = $('#id').val(), params
			if (id) {
				params = {
					id: id,
					field: 'name',
					table: table,
					value: value
				}
			} else {
				params = {
					field: 'name',
					table: table,
					value: value
				}
			}
			axios.post('/check', params)
				.then(res => {
					if (res.data == 'false') {
						valid = true
					} else {
						$('#' + field + '_txt').text(fieldtxt + '已经存在')
						valid = false
					}
				})
				.catch(err => {
					console.log(err)
				})
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.email = (field, value, isRequired = true) => {
	let valid = false, temp
	let reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/
	if (isRequired) {
		temp = required(field, '邮箱', value)
	}
	if (temp) {
		if (!reg.test(value)) {
			$('#' + field + '_txt').text('邮箱格式不对')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.password = (field, value, isRequired = true) => {
	let valid = false, temp
	if (isRequired) {
		temp = required(field, '密码', value)
	}
	if (temp) {
		if (value.length < 6) {
			$('#' + field + '_txt').text('密码至少要6位')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.repassword = (field, value, isRequired = true) => {
	let valid = false, temp
	if (isRequired) {
		temp = required(field, '确认密码', value)
	}
	if (temp) {
		if (value.length < 6) {
			$('#' + field + '_txt').text('确认密码至少要6位')
			valid = false
		} else {
			if ($('#password').val() !== value) {
				$('#' + field + '_txt').text('两次密码不一致')
				valid = false
			} else {
				$('#' + field + '_txt').text('')
				valid = true
			}
		}
	}
	return valid
}

exports.phone = (field, value) => {
	let valid = true
	if (value) {
		if (!/^1[34578]\d{9}$/.test(value)) {
			$('#' + field + '_txt').text('手机格式不对')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.realname = (field, value) => {
	let valid = true
	if (value) {
		if (value.length > 6) {
			$('#' + field + '_txt').text('姓名不能大于6位')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.birth_date = (field, value) => {
	let valid = true
	if (value) {
		if (!/^([0-9]{4})+-([0-1][1-9])+-([0-3][0-9])$/.test(value)) {
			$('#' + field + '_txt').text('出生日期格式为yyyy-mm-dd')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.scale = (field, value, isRequired = true) => {
	let valid = false, temp
	if (isRequired) {
		temp = required(field, '分销比例', value)
	}
	if (temp) {
		if (isNaN(parseFloat(value))) {
			$('#' + field + '_txt').text('请输入数字')
			valid = false
		} else if (value <= 0 || value > 1) {
			$('#' + field + '_txt').text('分销比例区间在0~1之间')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

exports.desc = (field, value) => {
	let valid = false, temp
	if (value) {
		if (value.length > 50) {
			$('#' + field + '_txt').text('角色描述在50个字内')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}
