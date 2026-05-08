<?php
require_once __DIR__ . '/Controller.php';

class EnquiryController extends Controller {

    private function collection() {
        return Database::getInstance()->getCollection('enquiries');
    }

    public function index(): void {
        $enquiries = $this->collection()->find([], ['sort' => ['created_at' => -1]])->toArray();
        $this->render('enquiries/index', compact('enquiries'));
    }

    public function view(): void {
        $id = $_GET['id'] ?? '';
        $enquiry = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        
        if ($enquiry && !($enquiry['read'] ?? false)) {
            $this->collection()->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => ['read' => true, 'read_at' => new MongoDB\BSON\UTCDateTime()]]
            );
        }
        
        $this->render('enquiries/view', compact('enquiry'));
    }

    public function delete(): void {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $this->collection()->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        }
        header('Location: index.php?page=enquiries&success=deleted');
        exit;
    }

    public function submit(): void {
        header('Content-Type: application/json');
        
        try {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $service = trim($_POST['service'] ?? '');
            $budget = trim($_POST['budget'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!$firstName || !$lastName || !$email || !$service || !$message) {
                echo json_encode(['success' => false, 'message' => 'Required fields missing']);
                exit;
            }

            $result = $this->collection()->insertOne([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'service' => $service,
                'budget' => $budget,
                'message' => $message,
                'read' => false,
                'created_at' => new MongoDB\BSON\UTCDateTime(),
            ]);

            echo json_encode([
                'success' => true, 
                'message' => 'Enquiry submitted successfully',
                'id' => (string)$result->getInsertedId()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function count(): void {
        header('Content-Type: application/json');
        $unreadCount = $this->collection()->countDocuments(['read' => false]);
        echo json_encode(['count' => $unreadCount]);
        exit;
    }
}
