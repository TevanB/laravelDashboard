This app is a basis for an E-Commerce website backend that requires the assignment of multiple orders at a time based on a MySQL Database.

There are three general User Types: Client, Worker, Admin.

It contains the entire primary system for automating a unique Service Business' ordering process.
1. Client orders on frontend ordering form
2. During Order Form, system asks for User Registration if Email in Order Form doesn't exist in account records through REST API calls.
3. Following PayPal API call for payments, Order is inserted in MySQL Database and Certain User types (workers) in backend dashboard are notified of new order placed.
- Clients are notifed by email of Order Confirmation as well as when their Order Status updates, and Admins get Discord Notifications through Discord's API of Order Updates
4. Clients are redirected to login after successful order placement, after Email Verification they can use the Client POV of their Dashboard
- Client POV gives them a summary of order steps as well as a custom dashboard to track their order, see updates, and have a direct Live Chat with their assigned worker.
5. Workers can see a CRUD type dashboard to claim orders when Clients place them, sound notification is activated to alert workers when new orders are in.
6. When order status is changed by a worker through their POV of the order dashboard, Administration approves of completion requests or worker reassignment requests.
- Depending on the Order status, REST API calls are made to change order status, create a new order in place of the new one for reassignment, or more.
7. The Admin role can see everything including all Order Dashboard as well as their own Payments screen to manage Order Status Change Requests, Admin Payouts, User Payouts, and track all orders.
- They call also see Charts powered by Chart.js for historical Order Placement Data and User Registration Data

Note: The /node folder is for the secondary javascript backend and is redundant in the main Heroku instance (can be seen on this repositories Procfile).
