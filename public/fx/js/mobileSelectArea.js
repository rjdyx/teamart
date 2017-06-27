module.exports = function () {
	let selectArea = new MobileSelectArea()
    selectArea.init({
    	trigger:$('.J_msa'),
    	value:$('.J_msa_data').val(),
    	data:'data.json'
    })
}