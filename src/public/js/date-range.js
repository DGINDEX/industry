$(function () {
	var dateFormat = 'YYYY/MM/DD';

	// 審査一覧
	// ドキュメント一覧
    $("#date-range").daterangepicker({
        autoUpdateInput: false,
		locale: {
			format: dateFormat,
			applyLabel: '反映',
			cancelLabel: '取消',
			fromLabel: '開始日',
			toLabel: '終了日',
			customRangeLabel: '指定'
        },
		ranges: {
			'本日': [moment(), moment()],
			'昨日': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'今月': [moment().startOf('month'), moment().endOf('month')],
			'先月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
			'直近10日': [moment().subtract('days', 9), moment()],
			'直近30日': [moment().subtract('days', 29), moment()],
			'直近90日': [moment().subtract('days', 89), moment()]
        }
    }).attr("autocomplete", "off");
    $("#date-range").on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat));
    });
    $("#date-range").on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});