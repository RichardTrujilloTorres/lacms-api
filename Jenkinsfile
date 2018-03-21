pipeline {
    agent { docker { image 'php' } }
    stages {
        stage('pre-build') {
            steps {
                sh 'php --version'
            }
        }
        stage('build') {
            steps {
                sh '''
                    echo "Multiline shell"
                    ls -lah
                '''
                sh '''
                    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                '''
                sh 'apt-get update && apt-get install -y php-zip'
            }
        }
    }
}
