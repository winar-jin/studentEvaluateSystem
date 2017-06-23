/**
 * Created by jin on 2017/5/22.
 */

/**
 * 返回当前的学期Term
 * @returns {string}
 */
function getTerm(){
    let nowMonth = new Date().getMonth();
    let term = [8, 9, 10, 11, 0, 1].includes(nowMonth) ? 2 : 1;
    return term;
}

/**
 * 返回Sctime
 * @returns {string}
 */
function getSctime() {
    let term =getTerm();
    let nowMonth = new Date().getMonth();
    let nowYear = new Date().getFullYear();
    if ([0, 1].includes(nowMonth)) {
        nowYear = nowYear - 1;
    }
    let templeTermChinese = (term === 1) ? '上' : '下';
    let sctime = nowYear + '-' + templeTermChinese;
    return sctime;
}

/**
 * 返回指定教师的课程列表
 * @param tid
 * @returns {AxiosPromise|*}
 */
function teacherCourseLsts(tid) {
    let term =getTerm();
    return axios.post('teacher/getcourselist', {
        Tid: tid,
        term: term
    });
}

/**
 * 返回教师的类型
 * @param tid
 * @returns {AxiosPromise|*}
 */
function getRole(tid) {
    return axios.post('teacher/getrole', {
        id: tid
    });
}

/**
 * 老师主观评价获取学生列表
 * @param name
 * @param tid
 */
function subjectiveStudent(name, tid) {
    let term =getTerm();
    let sctime = getSctime();
    return axios.post('teachercomment/subjective', {
        Cname: name,
        Tid: tid,
        Sctime: sctime,
        term: term
    });
}
/**
 * 更新教师个人信息
 * @param teacherInfo
 * @returns {*|AxiosPromise}
 */
function updateTeacherProfile(teacherInfo) {
    return axios.post('profile/teacher', {
        id: teacherInfo.Tid,
        name: teacherInfo.Tname,
        sex: teacherInfo.Tsex,
        apartment: teacherInfo.Tapartment,
        phone: teacherInfo.Tphone
    });
}

/**
 * 通过课程名返回成绩列表
 * @param cid
 * @returns {*|AxiosPromise}
 */
function getScoreByCname(cid) {
    return axios.post('teacher/getstudentscore/bycname', {
        Cid: cid,
        Sctime: getSctime()
    });
}

/**
 * 通过学号返回该学生的所有课程成绩
 * @param sid
 * @returns {*|AxiosPromise}
 */
function getScoreBySid(sid) {
    return axios.post('teacher/getstudentscore/bysid', {
        Sid: sid,
        Sctime: getSctime()
        // Sctime: '2017-上'
    });
}

/**
 * 更新学生的课程成绩
 * @param sid
 * @param sub
 * @param obj
 * @param cname
 * @returns {*|AxiosPromise}
 */
function stuScoreUpdate(sid, sub, obj, cname) {
    let scoreavg = ((sub + obj) / 2).toFixed(2);
    return axios.post('teacherscoreupdate', {
        Sid: sid,
        score_subjective: sub,
        score_objective: obj,
        score_avg: scoreavg,
        Cname: cname,
        Sctime: getSctime()
    });
}

/**
 * 教师搜索指定学生的评价结果
 * @param id
 * @param cname
 * @returns {*|AxiosPromise}
 */
function teachersearch(id, cname) {
    return axios.post('teachersearch',{
        id: id,
        Cname: cname,
        Sctime: getSctime()
    });
}

/**
 * 教师修改学生评价
 * @param sid
 * @param objective
 * @param subjective
 * @param cname
 * @return Promise
 */
function updateComment(sid,objective,subjective,cname){
    let avage = (objective+subjective)/2;
    return axios.post('teacherscoreupdate',{
        Sid:sid,
        score_subjective:subjective,
        score_objective:objective,
        score_avg:avage,
        Cname: cname,
        Sctime: getSctime()
    });
}
export {
    teacherCourseLsts,
    getRole,
    subjectiveStudent,
    updateTeacherProfile,
    getScoreByCname,
    getScoreBySid,
    stuScoreUpdate,
    teachersearch,
    updateComment
}