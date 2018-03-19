pipeline {
    agent { docker { image 'php' } }
    stages {
        stage('build') {
            steps {
                sh 'php --version'
                sh '''
                    echo "Multiline shell"
                    ls -lah
                '''
            }
        }
    }
}
