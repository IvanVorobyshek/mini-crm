<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Widget</title>
    @vite(['resources/js/widget.js', 'resources/css/widget.css'])
</head>
<body>
    <div class="widget-container">
        <h2>Contact us</h2>
        <div class="error error-global" id="globalError" style="display:none"></div>
        
        <div class="success" id="successMessage">
            Thank you! Your request has been sent.
        </div>

        <form id="feedbackForm">

            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="tel" id="phone" name="phone" placeholder="+380501234567" required>
                <div class="error" id="error-phone"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
                <div class="error" id="error-email"></div>
            </div>

            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required>
                <div class="error" id="error-subject"></div>
            </div>

            <div class="form-group">
                <label for="description">Message *</label>
                <textarea id="description" name="description" required></textarea>
                <div class="error" id="error-description"></div>
            </div>

            <div class="form-group">
                <label for="files">Files (optional)</label>
                <input type="file" id="files" name="files[]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <div class="error" id="error-files"></div>
            </div>

            <button type="submit" class="btn" id="submitBtn">Send</button>
        </form>

        <div class="loading" id="loading">Sending...</div>
    </div>

</body>
</html>