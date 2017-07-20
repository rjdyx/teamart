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

// const EXIF = require('exif-js')

// 此方法为file input元素的change事件
// function change() {
//     var file = this.files[0]
//     var orientation
//     //EXIF js 可以读取图片的元信息 https://github.com/exif-js/exif-js
//     EXIF.getData(file, function() {
//         orientation = EXIF.getTag(this, 'Orientation')
//     })
//     var reader = new FileReader()
//     reader.onload = function(e) {
//         getImgData(this.result, orientation, function(data) {
//             // 这里可以使用校正后的图片data了
//         })
//     }
//     reader.readAsDataURL(file)
// }

// // @param {string} img 图片的base64
// // @param {int} dir exif获取的方向信息
// // @param {function} next 回调方法，返回校正方向后的base64
// function getImgData(img, dir, next) {
//     var image = new Image()
//     image.onload = function() {
//         var degree = 0,
//             drawWidth, drawHeight, width, height
//         drawWidth = this.naturalWidth
//         drawHeight = this.naturalHeight
//         //以下改变一下图片大小
//         var maxSide = Math.max(drawWidth, drawHeight)
//         if (maxSide > 1024) {
//             var minSide = Math.min(drawWidth, drawHeight)
//             minSide = minSide / maxSide * 1024
//             maxSide = 1024
//             if (drawWidth > drawHeight) {
//                 drawWidth = maxSide
//                 drawHeight = minSide
//             } else {
//                 drawWidth = minSide
//                 drawHeight = maxSide
//             }
//         }
//         var canvas = document.createElement('canvas')
//         canvas.width = width = drawWidth
//         canvas.height = height = drawHeight
//         var context = canvas.getContext('2d')
//         //判断图片方向，重置canvas大小，确定旋转角度，iphone默认的是home键在右方的横屏拍摄方式
//         switch (dir) {
//             //iphone横屏拍摄，此时home键在左侧
//             case 3:
//                 degree = 180
//                 drawWidth = -width
//                 drawHeight = -height
//                 break
//                 //iphone竖屏拍摄，此时home键在下方(正常拿手机的方向)
//             case 6:
//                 canvas.width = height
//                 canvas.height = width
//                 degree = 90
//                 drawWidth = width
//                 drawHeight = -height
//                 break
//                 //iphone竖屏拍摄，此时home键在上方
//             case 8:
//                 canvas.width = height
//                 canvas.height = width
//                 degree = 270
//                 drawWidth = -width
//                 drawHeight = height
//                 break
//         }
//         //使用canvas旋转校正
//         context.rotate(degree * Math.PI / 180)
//         context.drawImage(this, 0, 0, drawWidth, drawHeight)
//         //返回校正图片
//         next(canvas.toDataURL("image/jpeg", .8))
//     }
//     image.src = img
// }

const EXIF = require('exif-js')

function toBlob (canvas, mimeType, quality) {
	mimeType = mimeType || 'image/png'

	return new Promise(function (resolve) {
		if (canvas.toBlob) {
			canvas.toBlob(function (blob) {
				return resolve(blob)
			}, mimeType, quality)
			return
		}

		// Fallback for old browsers
		var asString = atob(canvas.toDataURL(mimeType, quality).split(',')[1])
		var len = asString.length
		var asBuffer = new Uint8Array(len)

		for (var i = 0; i < len; i++) {
			asBuffer[i] = asString.charCodeAt(i)
		}

		resolve(new Blob([asBuffer], { type: mimeType }))
	})
}

function getImgData (base64, dir) {
	return new Promise(resolve => {
		let img = new Image()
		img.src = base64
		img.onload = function () {
			let degree = 0,
				drawWidth, drawHeight, width, height
			drawWidth = this.naturalWidth
			drawHeight = this.naturalHeight
			// let windowWidth = 640
			// // 以下改变一下图片大小
			// let maxSide = Math.max(drawWidth, drawHeight)
			// if (maxSide > windowWidth) {
			// 	let minSide = Math.min(drawWidth, drawHeight)
			// 	minSide = minSide / maxSide * windowWidth
			// 	maxSide = windowWidth
			// 	if (drawWidth > drawHeight) {
			// 		drawWidth = maxSide
			// 		drawHeight = minSide
			// 	} else {
			// 		drawWidth = minSide
			// 		drawHeight = maxSide
			// 	}
			// }
			// if (drawWidth > drawHeight) {
			// 	let temp = drawWidth
			// 	drawWidth = drawHeight
			// 	drawHeight = temp
			// }
			var canvas = document.createElement('canvas')
			canvas.width = width = drawWidth
			canvas.height = height = drawHeight
			var context = canvas.getContext('2d')
			// 判断图片方向，重置canvas大小，确定旋转角度，iphone默认的是home键在右方的横屏拍摄方式
			switch (dir) {
				// iphone横屏拍摄，此时home键在左侧
			case 3:
				degree = 180
				drawWidth = -width
				drawHeight = -height
				break
				// iphone竖屏拍摄，此时home键在下方(正常拿手机的方向)
			case 6:
				canvas.width = height
				canvas.height = width
				degree = 90
				drawWidth = width
				drawHeight = -height
				break
				// iphone竖屏拍摄，此时home键在上方
			case 8:
				canvas.width = height
				canvas.height = width
				degree = 270
				drawWidth = -width
				drawHeight = height
				break
			}
			// 使用canvas旋转校正
			context.rotate(degree * Math.PI / 180)
			context.drawImage(this, 0, 0, drawWidth, drawHeight)
			// 返回校正图片
			toBlob(canvas, 'image/jpeg', 50)
			.then(blob => {
				resolve(blob)
			})
		}
	})
}

function resizeImage (file) {
	return new Promise((resolve, reject) => {
		let orientation = 0
		// EXIF js 可以读取图片的元信息 https://github.com/exif-js/exif-js
		// EXIF.getData(file, function () {
		// 	orientation = EXIF.getTag(this, 'Orientation')
		// })
		let fr = new FileReader()
		fr.onload = function (e) {
			getImgData(e.target.result, orientation)
			.then(blob => {
				resolve(blob)
			})
			// let img = new Image()
			// img.src = e.target.result
			// img.onload = function () {
			// 	let that = this
			// 	let canvas = document.createElement('canvas')
			// 	canvas.width = that.width / scale
			// 	canvas.height = that.height * that.width / that.width / scale
			// 	canvas.getContext('2d').drawImage(that, 0, 0, canvas.width, canvas.height)
			// 	toBlob(canvas, 'image/jpeg', 50)
			// 	.then(blob => {
			// 		if (blob) {
			// 			resolve(blob)
			// 		} else {
			// 			reject(blob)
			// 		}
			// 	})
			// }
		}
		fr.readAsDataURL(file)
	})
}

module.exports = resizeImage
