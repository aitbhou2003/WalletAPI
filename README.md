**1. Register**

```

POST http://localhost:8000/api/register
Body: {
    "name": "name",
    "email": "name@example.com",
    "password": "password",
    "password_confirmation": "password"
}

```

**2. Login**

```

POST http://127.0.0.1:8000/api/login
Body: {
    "email": "name@example.com",
    "password": "password",
}

```

**3. LogOut ->copie le token reçu dans login ou register**

```

POST http://127.0.0.1:8000/api/logout
Headers → Authorization: Bearer {ton_token}

```

**4. Pour toutes les routes suivantes, ajoute dans Postman :**
```

Headers → Authorization: Bearer {ton_token}

```

**5. Add Wallet**

```

POST http://127.0.0.1:8000/api/wallets
Body: {
    "name": "Wallet Principal",
    "currency": "MAD"
}

```

**6. See all Wallets**

```

GET http://127.0.0.1:8000/api/wallets

```

**7. Show Wallet by Id**

```

GET http://127.0.0.1:8000/api/wallets/{id}

```

**8. Deposit**

```

POST http://127.0.0.1:8000/api/wallets/{id}/deposit
Body: {
    "amount": 500.00,
    "description": "Dépôt initial"
}

```

**9. withdraw**

```

POST http://127.0.0.1:8000/api/wallets/{id}/withdraw
Body: {
    "amount": 500.00,
    "description": "Dépôt initial"
}

```

**9. transfer**

```

POST http://127.0.0.1:8000/api/wallets/{id}/transfer
Body: {
    "receiver_wallet_id": 3,
    "amount": 100.00,
    "description": "Remboursement déjeuner"
}

```

**9. historique**

```

GET http://127.0.0.1:8000/api/wallets/{id}/transactions

```