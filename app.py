from flask import Flask

app=Flask(__name__)

@app.route('/')
def index():
    return '<h1> Bharathi webpage </h1> <p> See this My First Project</p>'

@app.route('/about')
def about():
    return '<h3> I am the VGLUG Foundation Vountreer</h3> <p> this page on control for Bharathi</p>'

@app.route('/contact')
def contact():
    return '<h4> Contact US </h4>'

if __name__=='__main__':
    app.run(debug=True)