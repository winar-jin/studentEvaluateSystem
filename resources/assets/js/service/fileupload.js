/**
 * 文件上传
 * @param  {} endpoint -> api URL
 * @param  {} fieldName -> ‘file’
 * @param  {} fileList -> 文件
 * @param  {} otherData -> 其他需要在http请求中传输的数据，对象类型
 * @return Promise
 */
export default function filesChange(endpoint, fieldName, fileList, otherData = null) {
    // 检测文件变化
    let formData = new FormData();
    // 若没有文件上传，就返回
    if (!fileList.length) return;
    // 将文件附加到FormData
    // formData.append(fieldName, fileList[0]);
    Array
        .from(Array(fileList.length).keys())
        .map(x => {
            formData.append(fieldName, fileList[x], fileList[x].name);
        });
    // 将参数中的额外的参数加到formData中
    if (otherData) {
        for (let name in otherData) {
            formData.append(name, otherData[name]);
        }
    }
    for (var pair of formData.entries()) {
        console.log(pair[1]);
        console.log(pair[0]);
    }
    // 发送ajax请求
    let instance = axios.create({
        timeout: 100000,
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        }
    });
    return instance.post(endpoint, formData);
}
