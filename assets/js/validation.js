// Validation des formulaires produits - GameCycle Style
class ProductValidator {
    constructor() {
        this.initEvents();
    }

    initEvents() {
        const forms = document.querySelectorAll('form[method="POST"]');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showMessage('Veuillez corriger les erreurs dans le formulaire', 'error');
                }
            });
        });

        this.initRealTimeValidation();
    }

    initRealTimeValidation() {
        const titleInput = document.getElementById('title');
        const priceInput = document.getElementById('price');
        const descriptionInput = document.getElementById('description');
        const imageInput = document.getElementById('image');

        if (titleInput) {
            titleInput.addEventListener('blur', () => this.validateTitle(titleInput));
            titleInput.addEventListener('input', () => this.validateTitle(titleInput));
        }

        if (priceInput) {
            priceInput.addEventListener('blur', () => this.validatePrice(priceInput));
            priceInput.addEventListener('input', () => this.validatePrice(priceInput));
        }

        if (descriptionInput) {
            descriptionInput.addEventListener('blur', () => this.validateDescription(descriptionInput));
            descriptionInput.addEventListener('input', () => this.validateDescription(descriptionInput));
        }

        if (imageInput) {
            imageInput.addEventListener('change', () => this.validateImage(imageInput));
        }
    }

    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            const fieldName = input.name;
            const value = input.value.trim();

            switch (fieldName) {
                case 'title':
                    if (!this.validateTitle(input)) isValid = false;
                    break;
                case 'price':
                    if (!this.validatePrice(input)) isValid = false;
                    break;
                case 'description':
                    if (!this.validateDescription(input)) isValid = false;
                    break;
                case 'category_id':
                    if (!this.validateCategory(input)) isValid = false;
                    break;
                case 'image':
                    if (!this.validateImage(input)) isValid = false;
                    break;
            }
        });

        return isValid;
    }

    validateTitle(input) {
        const value = input.value.trim();
        const minLength = 3;
        const maxLength = 100;

        this.removeError(input);

        if (value === '') {
            this.showError(input, 'Le titre est obligatoire');
            return false;
        }

        if (value.length < minLength) {
            this.showError(input, `Le titre doit contenir au moins ${minLength} caractères`);
            return false;
        }

        if (value.length > maxLength) {
            this.showError(input, `Le titre ne peut pas dépasser ${maxLength} caractères`);
            return false;
        }

        this.showSuccess(input);
        return true;
    }

    validatePrice(input) {
        const value = input.value.trim();

        this.removeError(input);

        if (value === '') {
            this.showError(input, 'Le prix est obligatoire');
            return false;
        }

        const price = parseFloat(value);
        if (isNaN(price) || price < 0) {
            this.showError(input, 'Le prix doit être un nombre positif');
            return false;
        }

        if (price > 10000) {
            this.showError(input, 'Le prix ne peut pas dépasser 10 000€');
            return false;
        }

        this.showSuccess(input);
        return true;
    }

    validateDescription(input) {
        const value = input.value.trim();
        const minLength = 10;
        const maxLength = 2000;

        this.removeError(input);

        if (value === '') {
            this.showError(input, 'La description est obligatoire');
            return false;
        }

        if (value.length < minLength) {
            this.showError(input, `La description doit contenir au moins ${minLength} caractères`);
            return false;
        }

        if (value.length > maxLength) {
            this.showError(input, `La description ne peut pas dépasser ${maxLength} caractères`);
            return false;
        }

        this.showSuccess(input);
        return true;
    }

    validateCategory(input) {
        const value = input.value;

        this.removeError(input);

        if (value === '') {
            this.showError(input, 'Veuillez sélectionner une catégorie');
            return false;
        }

        this.showSuccess(input);
        return true;
    }

    validateImage(input) {
        this.removeError(input);

        if (input.files.length > 0) {
            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                this.showError(input, 'Le fichier doit être une image (JPG, PNG, GIF, WebP)');
                return false;
            }

            if (file.size > maxSize) {
                this.showError(input, 'L\'image ne doit pas dépasser 5MB');
                return false;
            }
        }

        this.showSuccess(input);
        return true;
    }

    showError(input, message) {
        this.removeError(input);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `❌ ${message}`;

        input.classList.add('error');
        input.classList.remove('success');
        input.parentNode.appendChild(errorDiv);
    }

    showSuccess(input) {
        this.removeError(input);
        input.classList.add('success');
        input.classList.remove('error');
    }

    removeError(input) {
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
    }

    showMessage(message, type = 'info') {
        const existingMessages = document.querySelectorAll('.flash-message');
        existingMessages.forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = `alert alert-${type}`;
        messageDiv.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
        `;

        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);

        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }
}

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    new ProductValidator();
});

// Fonction de prévisualisation d'image
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const fileInfo = input.parentNode.querySelector('.file-info');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            fileInfo.textContent = input.files[0].name + ' (' + Math.round(input.files[0].size / 1024) + ' KB)';
            fileInfo.style.color = '#4cc9f0';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        fileInfo.textContent = 'Formats acceptés : JPG, PNG, GIF, WebP (max 5MB)';
        fileInfo.style.color = '#828282';
    }
}

// Ajout des styles d'animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .error-message {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);