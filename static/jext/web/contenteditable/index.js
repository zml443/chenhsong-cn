// $(document).on('select', '[contenteditable]', function (e) {
// 	e.stopPropagation();
// 	return false;
// });

const changeStyle = data => {
    data.value ? document.execCommand(data.command, false, data.value) : document.execCommand(data.command, false, null)
}
