import prompt from './prompt.js'

const ajax = (type, url, data = {}, isEdit = false, hasfile = false, errFn = true) => {
	let datas, config = {}
	if (type === 'get') {
		datas = {
			params: data
		}
	} else if (type === 'post') {
		Object.assign(data, { _token: Laravel.csrfToken })
		if (isEdit) {
			Object.assign(data, { _method: 'PUT' })
		}
		if (hasfile) {
			config = {
				headers: {
					'Content-Type': 'multiple/form-data'
				}
			}
			let fd = new FormData()
			for (let i in data) {
				// if (i === 'imgs[]') {
				if (data[i] instanceof Array) { // 如果是数组就需要添加数据
					data[i].forEach((v) => {
						console.dir(v)
						fd.append(i, v)
					})
				} else {
					if (data[i] instanceof Blob) {
						console.dir(data[i])
						fd.append(i, data[i], 'img')
					} else {
						fd.append(i, data[i])
					}
				}
			}
			datas = fd
		} else {
			datas = data
		}
	} else {
		datas = data
	}
	let pm = new Promise((resolve, reject) => {
		axios[type](url, datas, config)
			.then(res => {
				if (res.status === 200) {
					prompt.loadingEnd()
					resolve(res.data)
				}
			})
			.catch(err => {
				if (errFn) {
					if (err.response.status === 404) {
						prompt.message('请求地址不存在')
					} else if (err.response.status === 422) {
						let msg = ''
						Object.keys(err.response.data).forEach(v => {
							console.log(err.response.data[v][0])
							msg += `${err.response.data[v][0]}`
						})
						prompt.message(msg)
					} else if (err.response.status === 500) {
						prompt.message('服务器错误，请稍后再试')
					} else if (err.response.status === 401) {
						prompt.message('请先登录', 'http://' + window.location.host + '/login')
					} else {
						// prompt.message('请求错误')
						alert(err.message)
						prompt.message(err.message)
					}
				} else {
					reject(err)
				}
				prompt.loadingEnd()
				return false
			})
	})
	return pm
}

module.exports = ajax
