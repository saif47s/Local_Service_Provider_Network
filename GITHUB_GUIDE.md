# How to Upload Project to GitHub 🚀

Follow these steps to upload your complete code to GitHub.

### Step 1: Create a Repository on GitHub
1.  Open [GitHub.com](https://github.com/) and login.
2.  Click on the **+** icon (top right) -> **New repository**.
3.  **Repository Name:** `HyperLocal-Service-Provider` (or any name).
4.  **Privacy:** Public or Private.
5.  Click **Create repository**.
6.  Copy the URL (e.g., `https://github.com/yourname/repo.git`).

### Step 2: Run Commands in Terminal
Open your VS Code Terminal (Ctrl + `) and run these commands one by one:

1.  **Initialize Git:**
    ```powershell
    git init
    ```

2.  **Add All Files:**
    ```powershell
    git add .
    ```yh 

3.  **Commit Code:**
    ```powershell
    git commit -m "Complete Project Upload"
    ```

4.  **Link to GitHub (Paste your URL here):**
    ```powershell
    git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
    ```
    *(Replace the URL with the one you copied in Step 1)*

5.  **Rename Branch to Main:**
    ```powershell
    git branch -M main
    ```

6.  **Push Code:**
    ```powershell
    git push -u origin main
    ```

### ✅ Done!
Refresh your GitHub page, and you will see all your code there.
