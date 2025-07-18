<?php

namespace App\Controllers;

use App\Core\Controller;

class PagesController extends Controller
{
    public function about()
    {
        $this->render('pages/about', [
            'title' => 'About Us - ' . APP_NAME
        ]);
    }

    public function contact()
    {
        if ($this->request->isPost()) {
            return $this->handleContactForm();
        }

        $this->render('pages/contact', [
            'title' => 'Contact Us - ' . APP_NAME
        ]);
    }

    private function handleContactForm()
    {
        try {
            // Validate CSRF token
            $this->validateCsrf();

            // Get form data
            $data = [
                'first_name' => $this->request->post('first_name'),
                'last_name' => $this->request->post('last_name'),
                'email' => $this->request->post('email'),
                'phone' => $this->request->post('phone'),
                'subject' => $this->request->post('subject'),
                'message' => $this->request->post('message'),
                'newsletter' => $this->request->post('newsletter', 0)
            ];

            // Validate required fields
            $errors = [];
            if (empty($data['first_name'])) {
                $errors[] = 'First name is required';
            }
            if (empty($data['last_name'])) {
                $errors[] = 'Last name is required';
            }
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email address is required';
            }
            if (empty($data['subject'])) {
                $errors[] = 'Subject is required';
            }
            if (empty($data['message'])) {
                $errors[] = 'Message is required';
            }

            if (!empty($errors)) {
                $this->setFlash('error', implode(', ', $errors));
                return $this->render('pages/contact', [
                    'title' => 'Contact Us - ' . APP_NAME,
                    'error' => implode(', ', $errors)
                ]);
            }

            // Save contact message to database (optional)
            $this->saveContactMessage($data);

            // Send email notification (you can implement this)
            $this->sendContactNotification($data);

            // Subscribe to newsletter if requested
            if ($data['newsletter']) {
                $this->subscribeToNewsletter($data['email']);
            }

            $this->setFlash('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
            return $this->redirect('/contact');
        } catch (\Exception $e) {
            $this->setFlash('error', 'An error occurred while sending your message. Please try again.');
            return $this->render('pages/contact', [
                'title' => 'Contact Us - ' . APP_NAME,
                'error' => 'An error occurred while sending your message. Please try again.'
            ]);
        }
    }

    private function saveContactMessage($data)
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();

            // Create contacts table if it doesn't exist
            $createTable = "
                CREATE TABLE IF NOT EXISTS contacts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    first_name VARCHAR(100) NOT NULL,
                    last_name VARCHAR(100) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    phone VARCHAR(20),
                    subject VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    newsletter TINYINT(1) DEFAULT 0,
                    status ENUM('new', 'read', 'replied') DEFAULT 'new',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )
            ";
            $db->exec($createTable);

            // Insert contact message
            $stmt = $db->prepare("
                INSERT INTO contacts (first_name, last_name, email, phone, subject, message, newsletter)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone'],
                $data['subject'],
                $data['message'],
                $data['newsletter']
            ]);
        } catch (\Exception $e) {
            // Log error but don't fail the form submission
            error_log('Failed to save contact message: ' . $e->getMessage());
        }
    }

    private function sendContactNotification($data)
    {
        // This is where you would implement email sending
        // For now, we'll just log the message
        $message = "New contact form submission:\n";
        $message .= "Name: {$data['first_name']} {$data['last_name']}\n";
        $message .= "Email: {$data['email']}\n";
        $message .= "Phone: {$data['phone']}\n";
        $message .= "Subject: {$data['subject']}\n";
        $message .= "Message: {$data['message']}\n";

        error_log($message);

        // You can implement actual email sending here using PHPMailer or similar
        // Example:
        /*
        $mail = new PHPMailer();
        $mail->setFrom($data['email'], $data['first_name'] . ' ' . $data['last_name']);
        $mail->addAddress('support@modernshop.com');
        $mail->Subject = 'Contact Form: ' . $data['subject'];
        $mail->Body = $message;
        $mail->send();
        */
    }

    private function subscribeToNewsletter($email)
    {
        try {
            $db = \App\Core\Database::getInstance()->getConnection();

            // Create newsletter_subscribers table if it doesn't exist
            $createTable = "
                CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) UNIQUE NOT NULL,
                    status ENUM('active', 'unsubscribed') DEFAULT 'active',
                    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    unsubscribed_at TIMESTAMP NULL
                )
            ";
            $db->exec($createTable);

            // Insert or update subscriber
            $stmt = $db->prepare("
                INSERT INTO newsletter_subscribers (email, status, subscribed_at)
                VALUES (?, 'active', NOW())
                ON DUPLICATE KEY UPDATE
                status = 'active',
                subscribed_at = NOW(),
                unsubscribed_at = NULL
            ");

            $stmt->execute([$email]);
        } catch (\Exception $e) {
            // Log error but don't fail the form submission
            error_log('Failed to subscribe to newsletter: ' . $e->getMessage());
        }
    }

    public function privacy()
    {
        $this->render('pages/privacy', [
            'title' => 'Privacy Policy - ' . APP_NAME
        ]);
    }

    public function terms()
    {
        $this->render('pages/terms', [
            'title' => 'Terms of Service - ' . APP_NAME
        ]);
    }

    public function faq()
    {
        $this->render('pages/faq', [
            'title' => 'Frequently Asked Questions - ' . APP_NAME
        ]);
    }

    protected function setFlash($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }

    protected function getFlash($type)
    {
        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }
}
