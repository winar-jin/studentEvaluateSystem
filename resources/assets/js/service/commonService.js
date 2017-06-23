/**
 * Created by jin on 2017/5/17.
 */

/**
 * 获取用户的个人信息
 * @param role -> 角色（admin/student/teacher）
 * @param id -> 用户ID
 * @return 根据不同的角色返回用户的信息
 */
function profile(role, id) {
    return axios.post('profile', {
        role: role,
        id: id
    });
}

/**
 * 返回学生和老师的个人信息 
 * @param {any} target 
 * @param {any} id 
 * @returns Promise
 */
function searchInfo(target,id){
    return axios.post('searchinfo',{
        target: target,
        id: id
    })
}

/**
 * 更新用户头像
 * @param filePath
 * @param role
 * @param id
 * @return Promise
 */
function updateavatar(filePath,role,id){
    return axios.post('updateavatar',{
        filePath: filePath,
        role: role,
        id: id
    });
}

/**
 * 修改用户密码
 * @param password 对象
 * @param role 
 * @param id
 * @return Promise
 */
function changePass(password,role,id){
    return axios.post('updatepassword',{
        oldPassword: password.old,
        newPassword: password.new,
        role: role,
        id: id
    });
}

/**
 * 返回主页新闻
 */
function getHomeNews(){
    return axios.post('gethomenews');
}
export {profile,searchInfo,updateavatar,changePass,getHomeNews}