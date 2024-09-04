<?php
require_once 'connection.php';
class Course
{
    private string $code;
    private string $name;
    private string $population;

    public function __construct(string $code, string $name, string $population)
    {
        $this->code = $code;
        $this->name = $name;
        $this->population = $population;
    }

    public static function getAllPopulations()
    {
        $query = "SELECT DISTINCT program_assignment from programs;";
        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $populations = $stmt->fetchAll();
        foreach ($populations as $pop) {
            $pop_list[] = $pop['program_assignment'];
        };
        return $pop_list;
    }

    public static function getCourse(string $populaion)
    {
        $query =
            "SELECT  
        c.course_code, 
        c.course_name, 
        CONCAT(con.contact_first_name, ' ', con.contact_last_name) AS teacher, 
        COUNT(*) AS 'session count'
    FROM 
        courses c
    LEFT OUTER JOIN  sessions s ON c.course_code = s.session_course_ref
    LEFT OUTER JOIN  programs p ON c.course_code = p.program_course_code_ref
    LEFT OUTER JOIN  teachers t on s.session_prof_ref = t.teacher_epita_email
    LEFT OUTER JOIN  contacts con on t.teacher_contact_ref = con.contact_email
    WHERE 
        p.program_assignment LIKE '$populaion'
    GROUP BY 
        c.course_code, 
        c.course_name";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        return $courses;
    }

    public function addCourse()
    {
        $query1 =
            "INSERT INTO courses (course_code, course_name, course_rev) 
    VALUES('$this->code', '$this->name', 1);
    
    INSERT INTO programs (programs.program_course_code_ref,programs.program_course_rev_ref, programs.program_assignment) 
    VALUES('$this->code', 1, '$this->population');

    INSERT INTO exams (exams.exam_course_code, exams.exam_course_rev, exams.exam_weight, exams.exam_type) 
    VALUES('$this->code', 1, NULL, 'Quiz'); ";

        $con = Connection::getConnection();
        $con->exec($query1);

        $query2 = "SELECT student_epita_email FROM students WHERE student_population_code_ref = '$this->population';";
        $stmt = $con->prepare($query2);
        $stmt->execute();
        $students_mail = $stmt->fetchAll();

        foreach ($students_mail as $mail) {
            $student_email = $mail['student_epita_email'];
            $query3 =
                "INSERT INTO grades (grade_student_epita_email_ref, grade_course_code_ref, grade_course_rev_ref, grade_exam_type_ref, grade_score) 
        VALUES ('$student_email', '$this->code', 1, 'Quiz', NULL)";
            $con->exec($query3);
        }
    }

    public static function searchCourse(string $search)
    {
        $query =
            "SELECT  
        c.course_code, 
        c.course_name, 
        CONCAT(con.contact_first_name, ' ', con.contact_last_name) AS teacher, 
        p.program_assignment,
        COUNT(*) AS 'session count'
    FROM 
        courses c
    LEFT OUTER JOIN  sessions s ON c.course_code = s.session_course_ref
    LEFT OUTER JOIN  programs p ON c.course_code = p.program_course_code_ref
    LEFT OUTER JOIN  teachers t on s.session_prof_ref = t.teacher_epita_email
    LEFT OUTER JOIN  contacts con on t.teacher_contact_ref = con.contact_email
    WHERE 
        c.course_code like '%$search%' OR c.course_name like '%$search%'
    GROUP BY 
        c.course_code, 
        c.course_name,
        p.program_assignment";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        return $courses;
    }

    public static function getCourseById(string $code)
    {
        $query =
            "SELECT *
    FROM courses c
    JOIN programs p
    ON c.course_code = p.program_course_code_ref
    WHERE c.course_code like '$code'";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $course = $stmt->fetchAll();
        return $course;
    }

    public function assignCourse()
    {
        $query1 =
            "INSERT INTO programs(program_course_code_ref, program_course_rev_ref, program_assignment) 
    VALUES('$this->code', 1, '$this->population');";

        $con = Connection::getConnection();
        $con->exec($query1);

        $query2 = "SELECT student_epita_email FROM students WHERE student_population_code_ref = '$this->population';";
        $stmt = $con->prepare($query2);
        $stmt->execute();
        $students_mail = $stmt->fetchAll();

        foreach ($students_mail as $mail) {
            $student_email = $mail['student_epita_email'];
            $query3 =
                "INSERT INTO grades (grade_student_epita_email_ref, grade_course_code_ref, grade_course_rev_ref, grade_exam_type_ref, grade_score) 
        VALUES ('$student_email', '$this->code', 1, 'Quiz', NULL)";
            $con->exec($query3);
        }
    }
}
