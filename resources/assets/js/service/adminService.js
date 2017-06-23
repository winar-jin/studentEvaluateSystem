/**
 * 添加单个用户
 * @param target -> 添加用户类型
 * @param userInfo -> 用户的信息，对象类型
 */
function addSingleUser(target, userInfo) {
    if (target) {
        return axios.post('admin/addoneuser', {
            target: target,
            id: userInfo.id,
            name: userInfo.username,
            sex:userInfo.sex,
            apartment:userInfo.apartment,
            grade:userInfo.grade,
            phone:userInfo.phone,
            class:userInfo.class
        })
    }
}

/**
 * 添加公告
 * @param title -> 标题
 * @param bgImagePath -> 背景图片
 * @param type -> 类型（1：公告；2：校园新闻；3：院系新闻）
 * @param link -> 标题链接
 * @returns {*|AxiosPromise}
 */
function addBulletin(title, bgImagePath, type, link) {
    if(!bgImagePath){
        bgImagePath ='imags/3.jpg';
    }
    return axios.post('broadcast', {
        'title': title,
        'bgImagePath': bgImagePath,
        'type': type,
        'link': link
    });
}

/**
 * 更新管理员个人信息
 * @param adminId -> 管理员ID
 * @param adminName -> 管理员姓名
 * @param adminSex -> 管理员性别
 * @param adminPhone -> 管理员电话
 * @returns {*|AxiosPromise}
 */
function updateAdminProfie(adminId, adminName, adminSex, adminPhone) {
    return axios.post('profile/admin', {
        id: adminId,
        name: adminName,
        sex: adminSex,
        phone: adminPhone
    });
}

/**
 * 管理员查询用户信息
 * @param target -> student/teacher
 * @param id -> 学号、教职工号
 */
function searchInfo(target, id) {
    return axios.post('searchinfo', {
        target: target,
        id: id
    });
}

/**
 * 管理员修改教师信息
 * @param teacherInfo -> 教师信息，对象类型
 * @returns {*|AxiosPromise}
 */
function updateTeacher(teacherInfo) {
    return axios.post('profile/teacher', {
        "id": teacherInfo.id,
        "name": teacherInfo.name,
        "sex": teacherInfo.sex,
        "apartment": teacherInfo.apartment,
        "phone": teacherInfo.phone
    });
}

/**
 * 管理员修改学生信息
 * @param studentInfo
 * @returns {AxiosPromise|*}
 */
function updateStudent(studentInfo) {
    return axios.post('profile/student', {
        "id": studentInfo.id,
        "name": studentInfo.name,
        "sex": studentInfo.sex,
        "class": studentInfo.class,
        "grade": studentInfo.grade,
        "apartment": studentInfo.apartment
    });
}
/**
 * 删除毕业生信息
 * @returns {AxiosPromise|*}
 */
function deleteGraduate() {
    return axios.post('admin/deletegraduates');
}

/**
 * 删除指定用户信息
 * @param target
 * @param id
 * @returns {*|AxiosPromise}
 */
function deleteUser(target, id) {
    return axios.post('admin/deleteoneuser',{
        target: target,
        id:id
    });
}

export {addSingleUser, addBulletin, updateAdminProfie, searchInfo, updateTeacher, updateStudent, deleteGraduate,deleteUser}