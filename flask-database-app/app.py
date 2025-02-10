from flask import Flask, request, jsonify
from flask_cors import CORS
from supabase import create_client, Client

app = Flask(__name__)
# Allow requests from your client origin (adjust as needed)
CORS(app, resources={r"/*": {"origins": "https://ocs-test-client.vercel.app"}})

# Replace with your actual Supabase project credentials
SUPABASE_URL = "https://xxymbobojijnczeyaykj.supabase.co"
SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inh4eW1ib2JvamlqbmN6ZXlheWtqIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzkxODUzODksImV4cCI6MjA1NDc2MTM4OX0.E3-YNt8EO9Vyn63bWOk6lNtX9s4Z23Ay2ZQP3zjL_FQ"
supabase: Client = create_client(SUPABASE_URL, SUPABASE_KEY)


@app.route("/", methods=["GET"])
def get_users():
    user_id = request.args.get("id", "")
    pass_hash = request.args.get("pass", "")
    print("User ID:", user_id)
    print("Pass Hash:", pass_hash)

    # If credentials are missing, return an empty JSON array.
    if not user_id or not pass_hash:
        return jsonify([])

    # Query the "users" table for matching credentials.
    auth_response = supabase.table("users") \
        .select("*") \
        .eq("userid", user_id) \
        .eq("password_hash", pass_hash) \
        .execute()

    if auth_response.error is not None or not auth_response.data:
        return jsonify([])

    # Assume the first matching record is the authenticated user.
    user_record = auth_response.data[0]

    if user_record.get("role") == "admin":
        # If admin, fetch and return all user records.
        admin_response = supabase.table("users").select("*").execute()
        if admin_response.error is not None:
            return jsonify([])
        return jsonify(admin_response.data)
    else:
        # Otherwise, return only the authenticated user's record.
        return jsonify([user_record])


if __name__ == "__main__":
    app.run(debug=True)
