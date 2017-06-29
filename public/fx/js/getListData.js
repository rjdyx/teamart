import ajax from './ajax.js'

const getListData = (url, opts, template) => {
	ajax('get', url)
}

module.exports = getListData
