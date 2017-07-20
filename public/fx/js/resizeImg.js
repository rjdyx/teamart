const pica = require('pica')()

/**
 * 图片压缩，默认同比例压缩
 * @param {file} file
 * @param {Object} obj
 *   obj 对象 有 width， height， quality(0-1)
 * @param {Object} callback
 *   回调函数有一个参数，base64的字符串数据
 */
// function resize (file, obj = {width: 512, height: 512, quality: 0.5}) {
// 	let pm = new Promise((resolve, reject) => {
// 		var fr = new FileReader()
// 		fr.onload = function (e) {
// 			var img = new Image()
// 			img.src = e.target.result
// 			img.onload = function () {
// 				var that = this
// 				// 默认按比例压缩
// 				var w = that.width,
// 					h = that.height,
// 					scale = w / h
// 				w = obj.width || w
// 				h = obj.height || (w / scale)
// 				var quality = 0.7  // 默认图片质量为0.7
// 				// 生成canvas
// 				var canvas = document.createElement('canvas')
// 				var ctx = canvas.getContext('2d')
// 				// 创建属性节点
// 				var anw = document.createAttribute('width')
// 				anw.nodeValue = w
// 				var anh = document.createAttribute('height')
// 				anh.nodeValue = h
// 				canvas.setAttributeNode(anw)
// 				canvas.setAttributeNode(anh)
// 				ctx.drawImage(that, 0, 0, w, h)
// 				// 图像质量
// 				if (obj.quality && obj.quality <= 1 && obj.quality > 0) {
// 					quality = obj.quality
// 				}
// 				// quality值越小，所绘制出的图像越模糊
// 				var base64 = canvas.toDataURL('image/jpeg', quality)
// 				// 回调函数返回base64的值
// 				resolve(base64)
// 			}
// 		}
// 		fr.readAsDataURL(file)
// 	})
// 	return pm
// }

// function init (file) {
// 	resize(file, obj)
// 		.then(resolve => {

// 		})
// }

function resizeImage (file, scale = 2) {
	return new Promise((resolve, reject) => {
		let fr = new FileReader()
		fr.onload = function (e) {
			let img = new Image()
			img.src = e.target.result
			img.onload = function () {
				let that = this
				let canvas = document.createElement('canvas')
				canvas.width = that.width / scale
				canvas.height = that.height * that.width / that.width / scale
				canvas.getContext('2d').drawImage(that, 0, 0, canvas.width, canvas.height)
				pica.toBlob(canvas, 'image/jpeg', 50)
				.then(blob => {
					if (blob) {
						resolve(blob)
					} else {
						reject(blob)
					}
				})
			}
		}
		fr.readAsDataURL(file)
	})
}

module.exports = resizeImage
