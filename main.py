from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_marshmallow import Marshmallow
import os

app = Flask(__name__)

"""
@app.route('/',methods=['GET'])
def home():
    return jsonify(
        {
            'Name':'Bharathi',
            'Age':21,
            'Native':'Brammadesam',
            'City':'Villupuram',
            'fav number':1
        })
"""

basedir = os.path.abspath(os.path.dirname(__file__))
print(basedir)

app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///' + os.path.join(basedir, 'db.vglug')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
ma = Marshmallow(app)

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100))
    contact = db.Column(db.String(100), unique=True)

    def __init__(self, name, contact):
        self.name = name
        self.contact = contact

class UserSchema(ma.Schema):
    class Meta:
        fields = ('id', 'name', 'contact')

user_schema = UserSchema()
user_schemas = UserSchema(many=True)

if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True, port=5000)
