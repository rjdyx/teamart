/**
 * 必需字段
 *
 * @param field {string} 字段名称
 * @param fieldtxt {string} 字段汉字名称
 * @param value {string} 字段值
 * @returns {boolean}
 */
function required (field, fieldtxt, value) {
	if (value) {
		$('#' + field + '_txt').text('')
		return true
	} else {
		$('#' + field + '_txt').text(fieldtxt + '不能为空')
		return false
	}
}

function validname (field, fieldtxt, value, table, isRequired = true) {
	var valid = false, temp
	if (isRequired) {
		temp = required(field, fieldtxt, value)
	}
	if (temp) {
		if (value.length < 4) {
			$('#' + field + '_txt').text(fieldtxt + '不能少于4个字符')
			valid = false
		} else {
			var id = $('#id').val() ? $('#id').val() : false, params
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
			return axios.post('/check', params)
				.then(function(res) {
					if (res.data == 'false') {
						$('#' + field + '_txt').text('')
						valid = true
					} else {
						$('#' + field + '_txt').text(fieldtxt + '已经存在')
						valid = false
					}
					return valid
				})
				.catch(function(err) {
					console.log(err)
				})

		}
	}
	return valid
}

function validemail (field, value, isRequired = true) {
	var valid = false, temp
	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/
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

function validpassword (field, value, isRequired = true) {
	var valid = false, temp = true
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

function validrepassword (field, value, isRequired = true) {
	var valid = false, temp = true
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

function validphone (field, value) {
	var valid = true
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

function validrealname (field, value) {
	var valid = true
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

function validbirth_date (field, value) {
	var valid = true
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

function validscale (field, value, isRequired = true) {
	var valid = false, temp 
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

function validdesc (field, fieldtxt, value) {
	var valid = true
	if (value) {
		if (value.length > 50) {
			$('#' + field + '_txt').text(fieldtxt + '在50个字内')
			valid = false
		} else {
			$('#' + field + '_txt').text('')
			valid = true
		}
	}
	return valid
}

function validimg (field, file) {
	if (file.size / 1024 > 200) {
		$('#' + field + '_txt').text('图片太大')
		return false
	}
	if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
		$('#' + field + '_txt').text('图片格式只支持png和jpg')
		return false
	}
	$('#' + field + '_txt').text('')
	return true
}