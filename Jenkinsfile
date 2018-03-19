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
                sh '''
                    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
                '''
                sh 'uname -a'
            }
        }
    }
}
