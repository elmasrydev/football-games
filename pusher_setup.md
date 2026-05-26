# Pusher Channels Setup Guide

This guide walks you through signing up for Pusher Channels, creating an application, and retrieving your API credentials for production.

---

## Step 1: Create a Pusher Account
1. Go to [Pusher's Website](https://pusher.com/).
2. Click **Sign Up** in the top right.
3. You can register using your Google/GitHub account or email address.
4. Select the **Pusher Channels** product when prompted (do not select Beams or other products).

---

## Step 2: Create a Channels App
1. Once logged into your dashboard, click **Create App** (or go to the **Channels** tab on the sidebar and click **Create App**).
2. Configure your app:
   * **Name your app:** e.g., `Gamesiano Production`
   * **Select a cluster:** Choose a region closest to your target audience/server (e.g., `eu` for Europe, `us2` for US East).
   * **Choose your tech stack:** Select **Laravel** (backend) and **JavaScript** (frontend). *Note: This is just for documentation purposes on Pusher's end, it does not change your app settings.*
3. Click **Create App** at the bottom.

---

## Step 3: Retrieve Your API Keys
1. In your newly created app page, look at the sidebar and click on **App Keys**.
2. You will see a block of credentials containing:
   * `app_id`
   * `key`
   * `secret`
   * `cluster`

---

## Step 4: Configure Your Codebase

### A. Local Configuration (For Building Frontend)
Open your local [.env.production](file:///Users/macintosh/Herd/games/games_backend/.env.production) file and replace the placeholders with your live Pusher values:
```env
VITE_PUSHER_APP_KEY="YOUR_PUSHER_KEY_HERE"
VITE_PUSHER_APP_CLUSTER="YOUR_PUSHER_CLUSTER_HERE"
```

Then compile your production assets locally:
```bash
npm run build
```

### B. Live Server Configuration (For Laravel Broadcasts)
Open the `.env` file on your reseller hosting server and add the backend credentials:
```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID="YOUR_PUSHER_APP_ID_HERE"
PUSHER_APP_KEY="YOUR_PUSHER_KEY_HERE"
PUSHER_APP_SECRET="YOUR_PUSHER_SECRET_HERE"
PUSHER_APP_CLUSTER="YOUR_PUSHER_CLUSTER_HERE"
```
