export default function (title, data) {
    let content = '';
    content += '<span style="color: #e74c3c">' + data + '</span><br>';

    swal({
        title: title,
        type: 'error',
        text: content,
        html: true
    });
}
