var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function viewAlert(type, message){
    alertBody = document.createElement('div');
    alertBody.classList.add('alert', 'alert-' + type, 'alert-dismissible', 'fade', 'show', 'position-fixed', 'top-0', 'start-50', 'translate-middle-x', 'my-5');
    alertBody.setAttribute('role', 'alert');
    alertBody.style.cssText = "white-space: nowrap";
    content  = document.createTextNode(message);
    closeButton = document.createElement('button');
    closeButton.classList.add('btn-close', 'd-none');
    closeButton.setAttribute('type', 'button');
    closeButton.setAttribute('data-bs-dismiss', 'alert');
    closeButton.setAttribute('aria-label', 'Close');
    alertBody.appendChild(content);
    alertBody.appendChild(closeButton);
    document.body.appendChild(alertBody);
    setTimeout(function (){
        closeButton.click();
    }, 1000)
}

function cart() {
    fetch('/cart/all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            cartIndicator = document.querySelectorAll('#cart-indicator');
            if(cartIndicator){
                cartIndicator.forEach(element => {
                    element.classList.remove('d-none');
                })
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function addToCart(id, quantity = null) {
    data = null ;
    if (quantity) {
        data = { productId: id, quantity: quantity };
    } else {
        data = { productId: id };
    }
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.status >= 400 && response.status < 600) {
          return response.json().then(errorData => {
            viewAlert('danger', errorData.message);
            throw new Error(errorData.message);
          });
        }
        return response.json();
      })
      .then(data => {
        viewAlert('success', data.message);
        cartIndicator = document.querySelectorAll('#cart-indicator');
            if(cartIndicator){
                cartIndicator.forEach(element => {
                    element.classList.remove('d-none');
                })
            }
      })
    .catch(error => {
    });
}

function liveSearchListener(){
    document.getElementById("live-search-input").addEventListener("input", function(event) {
        if (event.target.value.trim()) {
            liveSearch(event.target.value);
        }
    });
}

function liveSearch(query) {
    fetch('/livesearch?query=' + query, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        removeLiveSearchContent();
        resultsPanel = document.getElementById('live-search-results');
        data['data'].forEach(element => {
            product = document.createElement('div');
            product.classList.add('d-flex', 'align-items-center');
            product_link = document.createElement('a');
            product_info = document.createElement('p');
            product_name = document.createElement('p');
            product_description = document.createElement('p');
            product_price = document.createElement('p');
            product_link.setAttribute('href', '/products/' + element.id);
            product_link.classList.add('d-flex', 'justify-content-between', 'flex-1', 'p-3', 'live-search-link', 'text-decoration-none');
            product_info.classList.add('d-flex','flex-column', 'flex-1');
            product_name.classList.add('m-0', 'fw-bold', 'fs-5', 'text-decoration-underline');
            product_description.classList.add('m-0','fs-6', 'text-dark');
            product_price.classList.add('m-0', 'fs-5');
            product_name.innerHTML = element.name;
            product_description.innerHTML = element.description;
            product_price.innerHTML = "Price : " + element.price;
            product_info.appendChild(product_name);
            product_info.appendChild(product_description);
            product_link.appendChild(product_info);
            product_link.appendChild(product_price);
            product.appendChild(product_link);
            resultsPanel.appendChild(product);
            hr = document.createElement('hr');
            hr.classList.add('m-0');
            resultsPanel.appendChild(hr);
        });
        if (data['to'] < data['total']) {
            more_link = document.createElement('a');
            more_link.classList.add('btn', 'btn-primary', 'align-self-center', 'mt-2')
            more_link.setAttribute('href', '?query=' + query + "#products");
            more_link.innerHTML = "More...";
            resultsPanel.appendChild(more_link);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function prepareForSearch() {
    removeLiveSearchContent();
    focusOnSearchField();
}

function removeLiveSearchContent() {
    document.getElementById('live-search-results').innerHTML = '';
}

function focusOnSearchField() {
    var myModal = document.getElementById('staticBackdrop');
    
    myModal.addEventListener('shown.bs.modal', function () {
        var myInput = document.getElementById('live-search-input');
        myInput.focus();
        myInput.value = '';
    });
}

function addTagToPaginationLinks(containerId, tag){
    container = document.getElementById(containerId);
    if (container) {
        links = container.querySelectorAll('a');
        if (links) {
            links.forEach(element => {
                element.href = element.href + "#" + tag;
            });
        }
    }
}

function addEventToCartQuantity() {
    cartQuantity = document.querySelectorAll('.cart-quantity');
    cartQuantity.forEach(element => {
        element.querySelector('.quantity').addEventListener('blur', function(){
            element.submit();
        })
    })
}

function disableAddressForms(){
    forms = document.querySelectorAll('.address-form');

    forms.forEach(element => {
        element.addEventListener('submit', function(e){
            e.preventDefault();
        });
    })

}

function createUserAddress() {
    form = document.querySelector('.address-form');
    districtField = form.querySelector("input[name='district']");
    streetField = form.querySelector("input[name='street']");
    buildingField = form.querySelector("input[name='building']");
    phoneField = form.querySelector("input[name='phone']");
    if (phoneField.value.length != 11) {
        viewAlert('danger', 'phone Field is too short');
    } else {
        const data = { 
            district: districtField.value, 
            street: streetField.value, 
            building: buildingField.value, 
            phone: phoneField.value, 
        };
        fetch('/address/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => {
    
            if (response.status >= 400 && response.status < 600) {
              return response.json().then(errorData => {
                throw new Error(errorData.message);
              });
              
            }
            
            return response.json();
          })
          .then(data => {
            viewAlert('success', data.message);
          })
        .catch(error => {
            viewAlert('danger', error);
        });
    }
}

function addAutoSubmitToFilteringOrders() {
    form = document.querySelector('.order-status-form');
    if (form) {
        form.querySelector('select').addEventListener('change', () => form.submit());
    }
}