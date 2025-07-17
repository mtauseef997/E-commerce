<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;
use App\Models\Order;
class UserController extends Controller
{
    private $userModel;
    private $orderModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->orderModel = new Order();
        $this->requireAuth();
    }
    public function profile()
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            $this->redirect('/login');
        }
        $addresses = $this->userModel->getAddresses($user['id']);
        $stats = $this->userModel->getStats($user['id']);
        $this->render('user/profile', [
            'title' => 'My Profile',
            'user' => $user,
            'addresses' => $addresses,
            'stats' => $stats,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function updateProfile()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/profile');
        }
        $userId = $this->getCurrentUserId();
        $this->validateCsrf();
        $data = [
            'first_name' => $this->request->post('first_name'),
            'last_name' => $this->request->post('last_name'),
            'email' => $this->request->post('email'),
            'phone' => $this->request->post('phone')
        ];
        $errors = $this->request->validate([
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'email' => 'required|email'
        ]);
        if ($this->userModel->emailExists($data['email'], $userId)) {
            $errors['email'][] = 'Email already exists';
        }
        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $field => $fieldErrors) {
                $errorMessages = array_merge($errorMessages, $fieldErrors);
            }
            $this->setFlash('error', implode('<br>', $errorMessages));
            $this->redirect('/profile');
        }
        $currentPassword = $this->request->post('current_password');
        $newPassword = $this->request->post('new_password');
        $confirmPassword = $this->request->post('confirm_password');
        if (!empty($currentPassword) && !empty($newPassword)) {
            $user = $this->userModel->find($userId);
            if (!$this->userModel->verifyPassword($currentPassword, $user['password'])) {
                $this->setFlash('error', 'Current password is incorrect.');
                $this->redirect('/profile');
            }
            if ($newPassword !== $confirmPassword) {
                $this->setFlash('error', 'New passwords do not match.');
                $this->redirect('/profile');
            }
            if (strlen($newPassword) < 6) {
                $this->setFlash('error', 'New password must be at least 6 characters.');
                $this->redirect('/profile');
            }
            $this->userModel->updatePassword($userId, $newPassword);
        }
        if ($this->userModel->update($userId, $data)) {
            $this->setFlash('success', 'Profile updated successfully.');
        } else {
            $this->setFlash('error', 'Failed to update profile.');
        }
        $this->redirect('/profile');
    }
    public function orders()
    {
        $userId = $this->getCurrentUserId();
        $page = (int) $this->request->get('page', 1);
        $limit = ORDERS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        $orders = $this->orderModel->getUserOrders($userId, $limit, $offset);
        $totalOrders = $this->orderModel->count(['user_id' => $userId]);
        $totalPages = ceil($totalOrders / $limit);
        $this->render('user/orders', [
            'title' => 'My Orders',
            'orders' => $orders,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_orders' => $totalOrders,
            'limit' => $limit,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function orderDetails($id)
    {
        $userId = $this->getCurrentUserId();
        $order = $this->orderModel->getOrderWithItems($id);
        if (!$order || $order['user_id'] != $userId) {
            $this->setFlash('error', 'Order not found.');
            $this->redirect('/orders');
        }
        $this->render('user/order-details', [
            'title' => 'Order #' . $order['order_number'],
            'order' => $order,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function wishlist()
    {
        $userId = $this->getCurrentUserId();
        $wishlist = $this->userModel->getWishlist($userId);
        $this->render('user/wishlist', [
            'title' => 'My Wishlist',
            'wishlist' => $wishlist,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function addresses()
    {
        $userId = $this->getCurrentUserId();
        $addresses = $this->userModel->getAddresses($userId);
        $this->render('user/addresses', [
            'title' => 'My Addresses',
            'addresses' => $addresses,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ]);
    }
    public function addAddress()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/addresses');
        }
        $userId = $this->getCurrentUserId();
        $this->validateCsrf();
        $data = [
            'type' => $this->request->post('type'),
            'first_name' => $this->request->post('first_name'),
            'last_name' => $this->request->post('last_name'),
            'company' => $this->request->post('company'),
            'address_line_1' => $this->request->post('address_line_1'),
            'address_line_2' => $this->request->post('address_line_2'),
            'city' => $this->request->post('city'),
            'state' => $this->request->post('state'),
            'postal_code' => $this->request->post('postal_code'),
            'country' => $this->request->post('country'),
            'phone' => $this->request->post('phone'),
            'is_default' => $this->request->post('is_default') ? 1 : 0
        ];
        $errors = $this->request->validate([
            'type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address_line_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required'
        ]);
        if (!empty($errors)) {
            $errorMessages = [];
            foreach ($errors as $field => $fieldErrors) {
                $errorMessages = array_merge($errorMessages, $fieldErrors);
            }
            $this->setFlash('error', implode('<br>', $errorMessages));
            $this->redirect('/addresses');
        }
        if ($this->userModel->addAddress($userId, $data)) {
            $this->setFlash('success', 'Address added successfully.');
        } else {
            $this->setFlash('error', 'Failed to add address.');
        }
        $this->redirect('/addresses');
    }
}