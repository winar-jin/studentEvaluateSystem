/**
 * Created by jin on 2017/5/19.
 */

/**
 * 根据学生ID返回指定学期的所有成绩
 * @param sid -> 学生ID
 * @param term -> 指定学期
 * @returns {*|AxiosPromise} -> 返回所有的成绩
 */
function getAllScore(sid, term) {
    return axios.post('getallscore', {
        Sid: sid,
        term: term
    });
}

/**
 * 返回学生的年级
 * @param sid
 * @returns {*|AxiosPromise}
 */
function getGrade(sid) {
    return axios.post('getgrade', {
        id: sid
    });
}

/**
 * 返回指定学生共有多少学期
 * @param sid -> 学号
 * @return totalTerm -> 总学期数目
 */
function getAllTerm(sid, fn) {
    getGrade(sid)
        .then(response => {
            let totalTerm = 0; // 总学期
            let res = response.data;
            if (res.success) {
                let grade = res.grade;
                if (grade > 0) {
                    let spring = [2, 3, 4, 5, 6, 7];
                    let autumn = [8, 9, 10, 12, 0, 1];
                    let loginMonth = new Date().getMonth();
                    // 上学期
                    if (spring.includes(loginMonth)) {
                        totalTerm = 2 * grade - 1;
                    } else if (autumn.includes(loginMonth)) {
                        totalTerm = 2 * grade;
                    }
                    fn(totalTerm);
                } else {
                    toastr.error('网络错误，请刷新网页重试！');
                }
            }
        })
        .catch(err => {
            throw err;
        });
}

/**
 * 返回指定学生所在学期的班级同学的所有同学及成绩
 * @param sid
 * @param term
 * @returns {AxiosPromise|*}
 */
function getClassmatesScore(sid, term) {
    return axios.post('getmclassmates', {
        id: sid,
        term: term
    });
}
/**
 * 学生互评
 * @param sid
 * @param score
 * @param term
 * @returns {*|AxiosPromise}
 */
function studentEva(sid, score, term) {
    return axios.post('commentclassmates', {
        sid: sid,
        score: score,
        term: term
    });
}

/**
 * 获取该学生本学期课程列表
 * @param id
 * @param term
 * @returns {*|AxiosPromise}
 */
function getCourseList(id, term) {
    return axios.post('student/getcourselist', {
        id: id,
        term: term
    });
}

export {getAllScore, getAllTerm, getClassmatesScore, studentEva,getCourseList};