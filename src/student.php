<?php
require_once 'connection.php';
class Student
{
    private string $fname;
    private string $lname;
    private string $email;
    private string $contact;
    private string $intake;
    private int $year;
    private string $population;
    private string $password;

    public function __construct(string $fname, string $lname, string $email, string $contact, string $intake, int $year, string $population)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->contact = $contact;
        $this->intake = $intake;
        $this->year = $year;
        $this->population = $population;
        $this->password = '';
    }

    public static function login(string $email, string $password):?string{
        session_start();
        $query = "SELECT * from students where student_epita_email='$email' and student_pass='$password'";
        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $student = $stmt->fetch();
        if(!empty($student)){ 
            $_SESSION['student_epita_email'] = $student['student_epita_email'];
            return $student['student_epita_email'];
        }else{
            return null;
        }
    }

    public static function checkLoggedInUser():bool{
        session_start();
        return isset($_SESSION['student_epita_email'])?true:false;
    }

    public static function logout(){
        session_start();
        session_destroy();
    }

    public static function isEmailExist(string $email):bool{
        $query = "SELECT count(*) as COUNTER from students where student_epita_email='$email'";
        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $mailExist = $stmt->fetch();
        
        $x = ($mailExist['COUNTER']>0)?true:false; 
        return $x;
    }

    public static function addPassword(string $email, string $password){
        $query = "UPDATE students SET student_pass = '$password' WHERE student_epita_email= '$email'";
        $con = Connection::getConnection();
        $con->exec($query);
    }

    public function addStudent(){
        $query = 
        "INSERT INTO contacts (contact_email, contact_first_name, contact_last_name) 
        VALUES('$this->contact', '$this->fname', '$this->lname');
        
        INSERT INTO students (student_epita_email, student_contact_ref, student_population_period_ref, student_population_year_ref, student_population_code_ref) 
        VALUES('$this->email', '$this->contact', '$this->intake', '$this->year', '$this->population')";

        $con = Connection::getConnection();
        $con->exec($query);
    }

    public static function deleteStudent(string $email) {
        $query = 
        "DELETE FROM contacts WHERE contact_email = (SELECT student_contact_ref FROM students WHERE student_epita_email = '$email') ";
        $con = Connection::getConnection();
        $con->exec($query);
    }

    public static function editStudent(string $fname, string $lname, string $email) {
        $query = 
        "UPDATE contacts c
        JOIN students s ON c.contact_email = s.student_contact_ref
        SET c.contact_first_name = '$fname',
            c.contact_last_name = '$lname'
        WHERE s.student_epita_email = '$email'";
       $con = Connection::getConnection();
       $con->exec($query);
    }

    public static function getStudents(string $population, int $year) {
        $query = 
        "SELECT 
        sub.student_epita_email, 
        sub.contact_first_name, 
        sub.contact_last_name, 
        CONCAT(sub.contact_first_name, ' ', sub.contact_last_name) AS full_name, 
        CASE 
            WHEN COUNT(sub.passed) = 1 OR COUNT(sub.passed) = 2 THEN NULL 
            ELSE CONCAT(sum(sub.passed), '/', count(sub.passed))
        END AS passed,
        sub.student_population_period_ref 
    FROM 
    (
        SELECT 
            s.student_epita_email, 
            c.contact_first_name, 
            c.contact_last_name, 
            s.student_population_period_ref, 
            g.grade_course_code_ref, 
            CASE 
                WHEN SUM(g.grade_score * e.exam_weight) / SUM(e.exam_weight) >= 10 THEN 1 
                ELSE 0 
            END AS passed 
        FROM students s 
        LEFT OUTER JOIN contacts c ON s.student_contact_ref = c.contact_email 
        LEFT OUTER JOIN grades g ON s.student_epita_email = g.grade_student_epita_email_ref 
        LEFT OUTER JOIN exams e ON g.grade_course_code_ref = e.exam_course_code 
        WHERE 
              s.student_population_code_ref LIKE '$population' AND
              s.student_population_year_ref LIKE '$year'
        GROUP BY 
            s.student_epita_email, 
            c.contact_first_name, 
            c.contact_last_name, 
            s.student_population_period_ref, 
            g.grade_course_code_ref
    ) AS sub 
    GROUP BY 
        sub.student_epita_email, 
        sub.contact_first_name, 
        sub.contact_last_name, 
        sub.student_population_period_ref 
    ORDER BY 
        sub.student_epita_email";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $students = $stmt->fetchAll();
        return $students;

    }

    public static function getStudentByMail(string $email) {
        $query = 
        "SELECT * FROM students s JOIN contacts c on s.student_contact_ref = c.contact_email
        WHERE student_epita_email = '$email'";
        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $stuArray = $stmt->fetchAll()[0];
        $student = new Student($stuArray['contact_first_name'], $stuArray['contact_last_name'], $stuArray['student_epita_email'], $stuArray['student_contact_ref'], 
        $stuArray['student_population_period_ref'], $stuArray['student_population_year_ref'], $stuArray['student_population_code_ref'], $stuArray['student_pass'] ?? '');
        return $student;
    }

    public static function searchStudent(string $search, int $year) {
        $query =
        "SELECT 
        sub.student_epita_email, 
        sub.contact_first_name, 
        sub.contact_last_name, 
        CONCAT(sub.contact_first_name, ' ', sub.contact_last_name) AS full_name, 
        CASE 
            WHEN COUNT(sub.passed) = 1 THEN NULL 
            ELSE CONCAT(sum(sub.passed), '/', count(sub.passed))
        END AS passed,
        sub.student_population_period_ref,
        sub.student_population_code_ref
    FROM 
    (
        SELECT 
            s.student_epita_email, 
            c.contact_first_name, 
            c.contact_last_name, 
            s.student_population_period_ref, 
            s.student_population_code_ref,
            g.grade_course_code_ref,
            CASE 
                WHEN SUM(g.grade_score * e.exam_weight) / SUM(e.exam_weight) >= 10 THEN 1 
                ELSE 0 
            END AS passed 
        FROM students s 
        LEFT OUTER JOIN contacts c ON s.student_contact_ref = c.contact_email 
        LEFT OUTER JOIN grades g ON s.student_epita_email = g.grade_student_epita_email_ref 
        LEFT OUTER JOIN exams e ON g.grade_course_code_ref = e.exam_course_code 
        WHERE 
        s.student_population_year_ref = '$year' AND 
    (
        s.student_epita_email LIKE '%$search%' OR 
        c.contact_last_name LIKE '%$search%' OR
        c.contact_first_name LIKE '%$search%'
    )
        GROUP BY 
            s.student_epita_email, 
            c.contact_first_name, 
            c.contact_last_name, 
            s.student_population_period_ref, 
            g.grade_course_code_ref,
            s.student_population_code_ref
    ) AS sub 
    GROUP BY 
        sub.student_epita_email, 
        sub.contact_first_name, 
        sub.contact_last_name, 
        sub.student_population_period_ref,
        sub.student_population_code_ref
    ORDER BY 
        sub.student_population_code_ref,
        sub.student_epita_email";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $students = $stmt->fetchAll();
        return $students;
    }

    public static function getGrades(string $email) {
        $query = 
        "SELECT 
            s.student_epita_email,
            c.contact_first_name,
            c.contact_last_name,
            CONCAT(c.contact_first_name, ' ', c.contact_last_name) AS fullname,
            s.student_population_period_ref,
            s.student_population_code_ref,
            g.grade_course_code_ref,
            ROUND((SUM(g.grade_score * e.exam_weight) / SUM(e.exam_weight)), 1) AS grade 
        FROM contacts c 
        LEFT JOIN students s ON c.contact_email = s.student_contact_ref 
        LEFT JOIN grades g ON s.student_epita_email = g.grade_student_epita_email_ref 
        LEFT JOIN exams e ON g.grade_course_code_ref = e.exam_course_code 
        WHERE 
            s.student_epita_email LIKE '$email' 
        GROUP BY 
            e.exam_course_code, 
            s.student_epita_email, 
            c.contact_last_name, 
            c.contact_last_name;";

        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
        $grades = $stmt->fetchAll();
        return $grades;
    }

    public static function deleteGrade(string $email, string $id) {
        $query = 
        "UPDATE grades g
        SET g.grade_score = NULL 
        WHERE g.grade_student_epita_email_ref like '$email' and g.grade_course_code_ref like '$id';";
        $con = Connection::getConnection();
        $stmt = $con->prepare($query);
        $stmt->execute();
    }

    public function getFname():string{
        return $this->fname;
    }

    public function getLname():string{
        return $this->lname;
    }

    public function getEmail():string{
        return $this->email;
    }
    public function getPassword():string{
        return $this->password;
    }

    public function getContact():string{
        return $this->contact;
    }

    public function getIntake():string{
        return $this->intake;
    }

    public function getYear():string{
        return $this->year;
    }

    public function getPopulation():string{
        return $this->population;
    }


}
